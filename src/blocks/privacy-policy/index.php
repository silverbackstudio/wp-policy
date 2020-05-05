<?php

function svbk_policy_privacy_block_render($attributes){
    return svbk_policy_content( 'privacy-policy', $attributes );
}

return array(
    'editor_script' => 'svbk-policy-blocks',
    'render_callback' => 'svbk_policy_privacy_block_render'
);