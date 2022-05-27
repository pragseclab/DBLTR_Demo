local common = require "/usr/local/lua/common"

if ngx.var.request_method == "POST" and ngx.var.username ~= "" and ngx.status == 302 then
    ngx.log(ngx.ERR, "Login post request detected")
    -- ngx.log(ngx.ERR, "Successful login for : " .. ngx.var.username)
    -- read session cookie
    local headers, err = ngx.resp.get_headers()
    if err then
        ngx.log(ngx.ERR, "err: ", err)
        return ngx.exit(500)
    end
    for k, v in pairs(headers) do
        if k:lower() == "set-cookie" then
            ngx.log(ngx.ERR, "Iterating over cookies: " .. k:lower())
            local set_cookie = v
            if (type(set_cookie) == "table") then
                for key, value in pairs(set_cookie) do
                    if string.match(value:lower(), "wordpress_logged_in") then
                        ngx.var.auth_cookie = common.split(common.split(value:lower(), "=")[2], ";")[1]
                        ngx.var.auth_cookie_name = common.split(value:lower(), "=")[1];
                        ngx.log(ngx.ERR, "Found set-cookie for " .. ngx.var.auth_cookie_name .. ": " .. value:lower())
                    end
                end
            elseif (type(set_cookie) == "string") then
                val = set_cookie:lower()
                ngx.var.auth_cookie = common.split(Split(val, "=")[2], ";")[1]
            end
        end
    end

    -- Save auth cookie username binding to Redis
    ngx.log(ngx.ERR, "Saving user binding " .. tostring(ngx.var.username))
    local ok, err = ngx.timer.at(0, common.save_user_binding, ngx.var.username, ngx.var.auth_cookie) 
end