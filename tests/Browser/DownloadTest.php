<?php

namespace Tests\Browser;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DownloadTest extends DuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $file = new Filesystem();
        $file->cleanDirectory('storage/temp');
    }

    /**
     * Test that the plugin download form downloads a .po plugin translation file
     *
     * @return void
     */
    public function testPluginDownload()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->select('translationType', 'plugin')
                ->select('translationFrom', 'dev')
                ->type('slug', 'wordpress-importer')
                ->select('originalLanguage', 'es')
                ->select('destinationLanguage', 'frp')
                ->click("#download-po");
            $browser->pause(1000);
            $this->assertFileExists(storage_path() . '/temp/wordpress-importer-frp.po');
        });
    }

    /**
     * Test that the plugin download form downloads a .po theme translation file
     *
     * @return void
     */
    public function testThemeDownload()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->select('translationType', 'theme')
                ->type('slug', 'twentynineteen')
                ->select('originalLanguage', 'es')
                ->select('destinationLanguage', 'frp')
                ->click("#download-po");
            $browser->pause(1000);
            $this->assertFileExists(storage_path() . '/temp/twentynineteen-frp.po');
        });
    }

    /**
     * Test that the plugin download form downloads a .po WordPress Development translation file
     *
     * @return void
     */
    public function testWordPressDevelopmentDownload()
    {
        $this->internalTestElementDownload('wordpress-development');
    }

    /**
     * Test that the plugin download form downloads a .po WordPress Continents & Cities translation file
     *
     * @return void
     */
    public function testWordPressContinentsCitiesDownload()
    {
        $this->internalTestElementDownload('wordpress-continents-cities');
    }

    /**
     * Test that the plugin download form downloads a .po WordPress Administration translation file
     *
     * @return void
     */
    public function testWordPressAdministrationDownload()
    {
        $this->internalTestElementDownload('wordpress-administration');
    }

    /**
     * Test that the plugin download form downloads a .po WordPress Network Admin translation file
     *
     * @return void
     */
    public function testWordPressNetworkAdminDownload()
    {
        $this->internalTestElementDownload('wordpress-network-admin');
    }

    /**
     * Test that the plugin download form downloads a .po Meta WordCamp translation file
     *
     * @return void
     */
    public function testMetaWordCampDownload()
    {
        $this->internalTestElementDownload('meta-wordcamp');
    }

    /**
     * Test that the plugin download form downloads a .po Meta WordPress.org translation file
     *
     * @return void
     */
    public function testMetaWordPressOrgDownload()
    {
        $this->internalTestElementDownload('meta-wordpress-org');
    }

    /**
     * Test that the plugin download form downloads a .po Meta WordPress Plugins Directory translation file
     *
     * @return void
     */
    public function testMetaWordPressPluginsDirectoryDownload()
    {
        $this->internalTestElementDownload('meta-wordpress-plugins-directory');
    }

    /**
     * Test that the plugin download form downloads a .po Meta Forums translation file
     *
     * @return void
     */
    public function testMetaForumsDownload()
    {
        $this->internalTestElementDownload('meta-forums');
    }

    /**
     * Test that the plugin download form downloads a .po Meta WordPress Theme Directory translation file
     *
     * @return void
     */
    public function testMetaWordPressThemeDirectoryDownload()
    {
        $this->internalTestElementDownload('meta-wordpress-theme-directory');
    }

    /**
     * Test that the plugin download form downloads a .po Meta o2 translation file
     *
     * @return void
     */
    public function testMetaO2Download()
    {
        $this->internalTestElementDownload('meta-o2');
    }

    /**
     * Test that the plugin download form downloads a .po Meta Rosetta translation file
     *
     * @return void
     */
    public function testMetaRosettaDownload()
    {
        $this->internalTestElementDownload('meta-rosetta');
    }

    /**
     * Test that the plugin download form downloads a .po Meta P2 Breathe translation file
     *
     * @return void
     */
    public function testMetaP2BreatheDownload()
    {
        $this->internalTestElementDownload('meta-p2-breathe');
    }

    /**
     * Test that the plugin download form downloads a .po Meta Browse Happy translation file
     *
     * @return void
     */
    public function testMetaBrowseHappyDownload()
    {
        $this->internalTestElementDownload('meta-browse-happy');
    }

    /**
     * Test that the plugin download form downloads a .po Meta Get Involved translation file
     *
     * @return void
     */
    public function testMetaGetInvolvedDownload()
    {
        $this->internalTestElementDownload('meta-get-involved');
    }

    /**
     * Test that the plugin download form downloads a .po Android translation file
     *
     * @return void
     */
    public function testAndroidDownload()
    {
        $this->internalTestElementDownload('android', 'es' , 'ca');
    }

    /**
     * Test that the plugin download form downloads a .po iOS translation file
     *
     * @return void
     */
    public function testIosDownload()
    {
        $this->internalTestElementDownload('ios', 'es' , 'ca');
    }

    protected function internalTestElementDownload($element, $originLanguage='es', $destinationLanguage='frp')
    {
        $this->browse(function (Browser $browser) use ($element, $originLanguage, $destinationLanguage) {
            $browser->visit('/')
                ->select('translationType', $element)
                ->select('originalLanguage', $originLanguage)
                ->select('destinationLanguage', $destinationLanguage)
                ->click("#download-po");
            $browser->pause(1000);
            $this->assertFileExists(storage_path() . '/temp/' . $element . '-' . $destinationLanguage . '.po');
        });
    }
}
