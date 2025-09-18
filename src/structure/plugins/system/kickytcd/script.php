<?php
/**
 * @package    [PACKAGE_NAME]
 *
 * @author     [AUTHOR] <[AUTHOR_EMAIL]>
 * @copyright  [COPYRIGHT]
 * @license    [LICENSE]
 * @link       [AUTHOR_URL]
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerScript;
use Joomla\Database\DatabaseInterface;

/**
 * KickYtcd script file.
 *
 * @package   plg_system_kickytcd
 * @since     1.0.0
 */
class plgSystemKickYtcdInstallerScript extends InstallerScript
{
    /**
     * Minimum PHP version required to install the extension
     *
     * @var    string
     * @since  3.6
     */
    protected $minimumPhp = '8.1.0';

    /**
     * Minimum Joomla! version required to install the extension
     *
     * @var    string
     * @since  3.6
     */
    protected $minimumJoomla = '5.0.0';

    /**
     * @param $type
     * @param $parent
     * @return true|void
     */
    public function preflight($type, $parent)
    {
        if (!in_array($type, ['install', 'update'])) {
            return true;
        }
        
        // Call parent to check minimum requirements
        return parent::preflight($type, $parent);
    }

    /**
     * @return void
     */
    public function install() {
        $db = $this->getDatabase();
        $query = $db->getQuery(true)
            ->update($db->quoteName('#__extensions'))
            ->set($db->quoteName('enabled') . ' = 1')
            ->where($db->quoteName('type') . ' = ' . $db->quote('plugin'))
            ->where($db->quoteName('folder') . ' = ' . $db->quote('system'))
            ->where($db->quoteName('element') . ' = ' . $db->quote('kickytcd'));
        
        $db->setQuery($query);
        $db->execute();
    }

    /**
     * Get database instance - modern API
     */
    private function getDatabase()
    {
        return Factory::getContainer()->get(DatabaseInterface::class);
    }
}
