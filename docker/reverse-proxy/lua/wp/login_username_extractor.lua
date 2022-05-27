ngx.req.read_body()
local post_params = ngx.req.get_post_args()
local username = nil

if post_params ~= nil and 
    string.match(ngx.var.request_uri, "wp%-login.php")
    then
        ngx.log(ngx.ERR, "Looking for username")
        -- WordPress
        if post_params["log"] ~= nil then
            username = post_params["log"]
            ngx.log(ngx.ERR, "username: " .. username)
        end
end

if username ~= nil then
    ngx.var.username = username
end