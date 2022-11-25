<?php namespace Waka\Session;

use Backend;
use Backend\Models\UserRole;
use System\Classes\PluginBase;

/**
 * Session Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'waka.session::lang.plugin.name',
            'description' => 'waka.session::lang.plugin.description',
            'author'      => 'Waka',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register(): void
    {

    }


    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'getSessionImage' => function ($twig, $code, $with = 600, $height = 300, $mode = 'auto') {
                    if(!$twig) return null;
                    //trace_log($code);
                    //trace_log($twig->user_keys()->get()->toArray());
                    $key = $twig->user_keys()->whereHas('waka_session', function($q) use($code, $with, $height, $mode) {
                            $q->where('name', $code);
                    })->with('images')->first();
                    if($key?->images) {
                        return $key->images->first()->getThumb( $with,$height, $mode);
                    } else {
                        return null;
                    }
                },
                
                
                
            ],
        ];
    }

    /**
     * Boot method, called right before the request route.
     */
    public function boot(): void
    {

    }

    /**
     * Registers any frontend components implemented in this plugin.
     */
    public function registerComponents(): array
    {
        return [
           'Waka\Session\Components\DataKey' => 'dataKey',
        ];
    }

    /**
     * Registers any backend permissions used by this plugin.
     */
    public function registerPermissions(): array
    {
        return []; // Remove this line to activate

        return [
            'waka.session.some_permission' => [
                'tab' => 'waka.session::lang.plugin.name',
                'label' => 'waka.session::lang.permissions.some_permission',
                'roles' => [UserRole::CODE_DEVELOPER, UserRole::CODE_PUBLISHER],
            ],
        ];
    }

    /**
     * Registers backend navigation items for this plugin.
     */
    public function registerNavigation(): array
    {
        return []; // Remove this line to activate

        return [
            'session' => [
                'label'       => 'waka.session::lang.plugin.name',
                'url'         => Backend::url('waka/session/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['waka.session.*'],
                'order'       => 500,
            ],
        ];
    }
}
