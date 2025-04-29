<?php
class ThemeTest extends WP_UnitTestCase {
    public function test_theme_setup() {
        $this->assertTrue( current_theme_supports('title-tag') );
        $this->assertTrue( current_theme_supports('post-thumbnails') );
    }
}