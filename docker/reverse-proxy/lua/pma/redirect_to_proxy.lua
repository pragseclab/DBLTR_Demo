local common = require "/usr/local/lua/common"

local proxy_header = ngx.req.get_headers()["proxy"]
if proxy_header ~= nil then
    ngx.var.proxy = proxy_header
else
    ngx.var.proxy = "1"
end
ngx.log(ngx.ERR, "setting proxy to " .. ngx.var.proxy)


-- read session cookie
if ngx.var["cookie_phpmyadmin"] ~= nil then
    ngx.log(ngx.ERR, "Checking username")
    ngx.var.auth_cookie = tostring(ngx.var["cookie_phpmyadmin"]:lower())
    local username = common.check_user_binding(ngx.var.auth_cookie)
    ngx.log(ngx.ERR, "Retrieved username " .. tostring(username) .. " for " .. ngx.var.auth_cookie)
    ngx.log(ngx.ERR, "type of username " .. type(username))
    if username ~= ngx.null then
        local proxy_id = tostring(common.get_proxy_id(username))
        ngx.log(ngx.ERR, "Overriding proxy id to " .. proxy_id)
        ngx.var.proxy = proxy_id
    end
end

if ngx.var.auth_cookie ~= "" and ngx.var.auth_cookie ~= ngx.null and ngx.var.auth_cookie ~= false then
    local original_auth_cookie = ngx.var.auth_cookie
    -- Handle changing of the auth cookie
    -- read session cookie
    local headers, err = ngx.resp.get_headers()
    if err then
        ngx.log(ngx.ERR, "err: ", err)
        return ngx.exit(500)
    end
    for k, v in pairs(headers) do
        if k:lower() == "set-cookie" then
            local set_cookie = v
            if (type(set_cookie) == "table") then
                for key, value in pairs(set_cookie) do
                    if string.match(value:lower(), "phpmyadmin") then
                        ngx.var.auth_cookie = common.split(common.split(value:lower(), "=")[2], ";")[1]
                        ngx.log(ngx.ERR, "Found override set-cookie for phpmyadmin: " .. value:lower())
                    end
                end
            elseif (type(set_cookie) == "string") then
                val = set_cookie:lower()
                ngx.var.auth_cookie = common.split(common.split(val, "=")[2], ";")[1]
            end
        end
    end

    -- Save auth cookie username binding to Redis
    ngx.log(ngx.ERR, "BF Checking original auth cookie " .. tostring(original_auth_cookie) .. "=>" .. tostring(username))
    local username = common.check_user_binding(original_auth_cookie)
    ngx.log(ngx.ERR, "AF Checking original auth cookie " .. tostring(original_auth_cookie) .. "=>" .. tostring(username))
    if username ~= ngx.null then
        ngx.log(ngx.ERR, "Saving user binding probably faulty " .. tostring(username))
        local ok, err = ngx.timer.at(0, common.save_user_binding, username, ngx.var.auth_cookie) 
    else
        ngx.log(ngx.ERR, "Username is null")
    end
end