<?php namespace Waka\Session\Components;

use BackendAuth;
use Cms\Classes\ComponentBase;
use Redirect;
use Waka\Session\Models\UserKey;

class DataKey extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'UserKey Component',
            'description' => "Permet d'ifentifer un utilisateur",
        ];
    }

    public function defineProperties()
    {
        return [
            'btn_color' => [
                'title' => 'Couleur',
                'description' => 'Couleur du bouton',
                'default' => null,
                'type' => 'string',
            ],
        ];
    }

    public function onRun()
    {
        $this->addJs('assets/js/waiter.js');
        
        $key = $this->param('key');
        $source = UserKey::where('name', $key)->first();
        //
        if (!$source) {
            return Redirect::to('/lp/bad_cod');
        }
        //
        if (!$source->valide) {
            return Redirect::to('/lp/deleted_cod');
        }
        // $b_user = BackendAuth::getUser();
        // if (!$b_user) {
        //     $source->visites = $source->visites + 1;
        //     $source->save();
        // }
        
        $this->page['userKey'] = [
                'code' => $key,
                'name' => $key,
                'end_key_at' => $source->key_end_at
        ];
        $this->page['dataKey'] = $source->dseable;
        $this->page['asks'] = $source->data['asks'] ?? [];
        $this->page['fncs'] = $source->data['fncs'] ?? [];
    }

    // public function getKeyData() {
    //     $key = $this->param('key');
    //     $source = UserKey::where('key', $key)->first();
    //     //
    //     if (!$source) {
    //         return Redirect::to('/lp/bad_cod');
    //     }
    //     //
    //     if (!$source->valide) {
    //         return Redirect::to('/lp/deleted_cod');
    //     }
    //     // $b_user = BackendAuth::getUser();
    //     // if (!$b_user) {
    //     //     $source->visites = $source->visites + 1;
    //     //     $source->save();
    //     // }
    //     return [
    //         'userKey' => $source,
    //         'dataKey' => $source->dseable,
    //     ];

    // }
    
    public function onRemoveKey()
        {
            $key = $this->param('key');
            $source = UserKey::where('name', $key)->first();
            $source->user_delete_key = true;
            $source->save();
            return \Redirect::to('/lp/deleted_cod');
        }
}
