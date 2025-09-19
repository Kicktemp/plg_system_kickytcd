<?php
/**
 * @package    [PROJECT_NAME]
 *
 * @author     [AUTHOR] <[AUTHOR_EMAIL]>
 * @copyright  [COPYRIGHT]
 * @license    [LICENSE]
 * @link       [AUTHOR_URL]
 */

namespace Kicktemp\Plugin\System\KickYtcd\Extension;

use Joomla\CMS\Plugin\CMSPlugin;
use YOOtheme\Application;
use YOOtheme\Path;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

final class KickYtcd extends CMSPlugin
{
    protected $modulus = [
        'Example'
    ];

    public function onAfterInitialise()
    {
        // Check if YOOtheme Pro is loaded
        if (!class_exists(Application::class, false)) {
            return;
        }

        $modules = [];
        foreach ($this->modulus as $addon) {
            if ($this->params->get(strtolower($addon), true)) {
                $modules[] = $addon;
            }
        }

        $app = Application::getInstance();
        foreach ($modules as $module) {
            $app->load(JPATH_PLUGINS . '/system/kickytcd/src/modules/{' . $module . '{,-joomla}}/bootstrap.php');
        }
    }
}