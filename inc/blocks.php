<?php

add_action('init', function () {
  $blocks = ['ac-toc'];
  foreach ($blocks as $block) {
    register_block_type(get_template_directory() . "/blocks/{$block}");
  }
});



// Debug: Log all registered blocks to console
add_action('admin_footer', function() {
    if (!is_admin() || !function_exists('get_current_screen')) {
        return;
    }

    $screen = get_current_screen();
    if (!$screen || $screen->base !== 'post') {
        return;
    }

    $registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
    $block_data = [];

    foreach ($registered_blocks as $block_name => $block_type) {
        $block_data[$block_name] = [
            'name' => $block_type->name,
            'title' => $block_type->title ?? 'No title',
            'category' => $block_type->category ?? 'No category',
            'icon' => $block_type->icon ?? 'No icon',
            'description' => $block_type->description ?? 'No description',
            'supports' => $block_type->supports ?? [],
            'editor_script' => $block_type->editor_script ?? 'No editor script',
            'editor_style' => $block_type->editor_style ?? 'No editor style',
            'style' => $block_type->style ?? 'No style',
            'attributes' => $block_type->attributes ?? [],
        ];
    }

    ?>
    <script>
    console.group('🧱 WordPress Blocks Debug Info');
    console.log('Total registered blocks:', <?php echo count($block_data); ?>);
    console.log('All registered blocks:', <?php echo wp_json_encode($block_data, JSON_PRETTY_PRINT); ?>);

    // Check specifically for your custom blocks
    const customBlocks = Object.keys(<?php echo wp_json_encode($block_data); ?>).filter(name =>
        name.startsWith('ac/') || name.includes('atlantic')
    );

    if (customBlocks.length > 0) {
        console.group('🎯 Your Custom Blocks');
        customBlocks.forEach(blockName => {
            console.log(`Block: ${blockName}`, <?php echo wp_json_encode($block_data); ?>[blockName]);
        });
        console.groupEnd();
    } else {
        console.warn('⚠️ No custom blocks found with "ac/" prefix');
    }

    console.groupEnd();
    </script>
    <?php
});

// Also add PHP error logging for block registration
add_action('init', function() {
    error_log('=== Block Registration Debug ===');
    error_log('Theme directory: ' . get_template_directory());

    $blocks_dir = get_template_directory() . '/blocks';
    if (!is_dir($blocks_dir)) {
        error_log('Blocks directory does not exist: ' . $blocks_dir);
        return;
    }

    $block_folders = glob($blocks_dir . '/*', GLOB_ONLYDIR);
    error_log('Found block folders: ' . print_r($block_folders, true));

    foreach ($block_folders as $folder) {
        $block_json = $folder . '/block.json';
        if (file_exists($block_json)) {
            error_log('Found block.json in: ' . $folder);
            $json_content = file_get_contents($block_json);
            error_log('Block.json content: ' . $json_content);
        } else {
            error_log('No block.json found in: ' . $folder);
        }
    }
}, 5); // Run early to catch registration issues


add_action('admin_footer', function() {
    $screen = get_current_screen();
    if ($screen && $screen->base === 'post') {
        ?>
        <script>
        // Wait for the editor to load
        setTimeout(() => {
            if (wp.data && wp.data.select) {
                const inserterItems = wp.data.select('core/block-editor').getInserterItems();
                const myBlock = inserterItems.find(item => item.name === 'ac/ac-toc');

                console.log('🔍 Block in inserter items:', myBlock);
                console.log('📝 Total inserter items:', inserterItems.length);

                // Also check block variations
                if (myBlock) {
                    console.log('✅ Your block IS available in inserter');
                } else {
                    console.log('❌ Your block is NOT in inserter items');
                    // Log some similar blocks for comparison
                    const widgetBlocks = inserterItems.filter(item =>
                        item.category === 'widgets' || item.name.includes('toc')
                    );
                    console.log('🔧 Widget category blocks:', widgetBlocks);
                }
            }
        }, 3000);
        </script>
        <?php
    }
});


add_action('admin_footer', function() {
    $screen = get_current_screen();
    if ($screen && $screen->base === 'post') {
        ?>
        <script>
        // Check for block validation errors
        setTimeout(() => {
            if (wp.data && wp.data.select) {
                // Check if there are any block validation errors
                const notices = wp.data.select('core/notices').getNotices();
                console.log('📢 Editor notices:', notices);

                // Try to get block validation details
                const blockTypes = wp.blocks.getBlockTypes();
                const myBlockType = blockTypes.find(bt => bt.name === 'ac/ac-toc');
                console.log('🔍 My block type details:', myBlockType);

                if (myBlockType) {
                    // Test if we can validate the block
                    try {
                        const testBlock = wp.blocks.createBlock('ac/ac-toc');
                        console.log('✅ Test block creation successful:', testBlock);
                    } catch (e) {
                        console.error('❌ Test block creation failed:', e);
                    }
                }
            }
        }, 3000);
        </script>
        <?php
    }
});



add_action('admin_footer', function() {
    $screen = get_current_screen();
    if ($screen && $screen->base === 'post') {
        ?>
        <script>
        setTimeout(() => {
            if (wp.data && wp.data.select) {
                // Check inserter settings
                const settings = wp.data.select('core/block-editor').getSettings();
                console.log('⚙️ Editor settings:', settings);

                // Check if there are allowed blocks restrictions
                if (settings.allowedBlocks) {
                    console.log('🚫 Allowed blocks restriction:', settings.allowedBlocks);
                    const isAllowed = settings.allowedBlocks.includes('ac/ac-toc');
                    console.log('✅ Is ac/ac-toc allowed?', isAllowed);
                }

                // Check template lock
                if (settings.templateLock) {
                    console.log('🔒 Template lock:', settings.templateLock);
                }

                // Check if block supports inserter
                const blockType = wp.blocks.getBlockType('ac/ac-toc');
                console.log('🔧 Block supports:', blockType?.supports);
                console.log('📝 Block inserter setting:', blockType?.supports?.inserter);
            }
        }, 3000);
        </script>
        <?php
    }
});



add_action('admin_footer', function() {
    $screen = get_current_screen();
    if ($screen && $screen->base === 'post') {
        ?>
        <script>
        setTimeout(() => {
            if (wp.data && wp.data.select) {
                const inserterItems = wp.data.select('core/block-editor').getInserterItems();

                // Look for any blocks starting with 'ac/'
                const acBlocks = inserterItems.filter(item => item.name.startsWith('ac/'));
                console.log('🔍 AC blocks in inserter:', acBlocks);

                // Check text category blocks
                const textBlocks = inserterItems.filter(item => item.category === 'text');
                console.log('📝 Text category blocks:', textBlocks.map(b => b.name));

                // Check if our block appears anywhere
                const myBlock = inserterItems.find(item => item.name === 'ac/ac-toc');
                console.log('🎯 My block in inserter:', myBlock);
            }
        }, 3000);
        </script>
        <?php
    }
});


add_filter('allowed_block_types_all', function($allowed_blocks, $editor_context) {
    if (is_array($allowed_blocks)) {
        error_log('Allowed blocks filter is restricting blocks. Count: ' . count($allowed_blocks));
        error_log('First 10 allowed: ' . print_r(array_slice($allowed_blocks, 0, 10), true));
        error_log('Is ac/ac-toc allowed? ' . (in_array('ac/ac-toc', $allowed_blocks) ? 'YES' : 'NO'));
    } else {
        error_log('No block restrictions (allowed_blocks is not an array)');
    }
    return $allowed_blocks;
}, 10, 2);
