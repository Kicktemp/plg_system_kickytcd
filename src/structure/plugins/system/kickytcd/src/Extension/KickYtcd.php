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
use Joomla\Event\SubscriberInterface;
use YOOtheme\Application;
use YOOtheme\Path;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

final class KickYtcd extends CMSPlugin implements SubscriberInterface
{
    /**
     *
     * @var array
     */
    protected $modulus = [
        'Example'
    ];

    /**
     * Returns an array of events this subscriber will listen to.
     *
     * @return  array
     *
     * @since   4.0.0
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onAfterInitialise' => 'initYOOtheme',
        ];
    }


    public function initYOOtheme()
    {
        // Check if YOOtheme Pro is loaded
        if (!class_exists(Application::class, false)) {
            return;
        }

        $app = Application::getInstance();

        Path::setAlias('~kickytcd', JPATH_PLUGINS . '/system/kickytcd/src');
        $modules = [];

        foreach ($this->modulus as $addon) {
            if ($this->params->get(strtolower($addon), true)) {
                $modules[] = $addon;
            }
        }

        foreach ($modules as $module) {
            $app->load('~kickytcd/modules/{' . $module . '{,-joomla}}/bootstrap.php');
        }
    }
}