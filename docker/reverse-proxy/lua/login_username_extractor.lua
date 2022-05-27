ngx.req.read_body()
local post_params = ngx.req.get_post_args()
local username = nil
if post_params ~= nil and 
    (string.find(ngx.var.request_uri, "/") 
        or string.find(ngx.var.request_uri, "index.php")) 
    then
    -- phpMyAdmin
    if post_params["pma_username"] ~= nil then
        username = post_params["pma_username"]
        ngx.log(ngx.ERR, "username: " .. username)
    end
end

if username ~= nil then
    ngx.var.username = username
end