local M = {}

function M.save_user_binding(premature, username, cookie)
    if premature then
        return
    end
    ngx.log(ngx.ERR, "redis")
    ngx.log(ngx.ERR, username)
    ngx.log(ngx.ERR, cookie)
    local redis = require "resty.redis"
    local red = redis:new()

    red:set_timeouts(1000, 1000, 1000) -- 1 sec
    local ok, err = red:connect("redis", 6379)
    if not ok then
        ngx.log(ngx.ERR, "Failed to connect to redis")
        return ngx.exit(500)
    end

    ngx.log(ngx.ERR, "Setting in redis " .. cookie .. '=>' .. username)
    ok, err = red:set("CK_PMA_" .. cookie, username)
    if not ok then
        ngx.log(ngx.ERR, "Failed to write to redis")
        return ngx.exit(500)
    end
end

function M.split(s, delimiter)
    local result = {};
    for match in (s..delimiter):gmatch("(.-)"..delimiter) do
        table.insert(result, match);
    end
    return result;
end

function M.check_user_binding(cookie)
    local redis = require "resty.redis"
    local red = redis:new()

    red:set_timeouts(1000, 1000, 1000) -- 1 sec
    local ok, err = red:connect("redis", 6379)
    if not ok then
        ngx.log(ngx.ERR, "Failed to connect to redis")
        return ngx.exit(500)
    end

    ngx.log(ngx.ERR, "check user binding cookie is "..tostring(cookie))
    res, err = red:get("CK_PMA_" .. cookie)
    if not res then
        ngx.log(ngx.ERR, "Failed to read from redis")
        return ngx.exit(500)
    end
    ngx.log(ngx.ERR, "Returning " .. tostring(res) .. " for " .."CK_PMA_" .. cookie)
    return res
end

function M.get_proxy_id(username)
    local redis = require "resty.redis"
    local red = redis:new()

    red:set_timeouts(1000, 1000, 1000) -- 1 sec
    local ok, err = red:connect("redis", 6379)
    if not ok then
        ngx.log(ngx.ERR, "Failed to connect to redis")
        return ngx.exit(500)
    end

    res, err = red:get("MP_PMA_" .. username)
    if not res then
        ngx.log(ngx.ERR, "Failed to read from redis")
        return ngx.exit(500)
    end
    return res
end

return M