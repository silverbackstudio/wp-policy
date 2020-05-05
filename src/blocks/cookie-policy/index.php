<?php

function svbk_policy_cookie_block_render($attributes){
    return svbk_policy_content( 'cookie-policy', $attributes );
}

return array(
    'editor_script' => 'svbk-policy-blocks',
    'render_callback' => 'svbk_policy_cookie_block_render'
);