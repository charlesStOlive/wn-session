<?php

namespace Waka\Session\Classes;

use Carbon\Carbon;
use Waka\Session\Models\UserKey;
use Waka\Session\Models\WakaSession;



class ManageKey
{

    public static function createKey(WakaSession $session, $data, $dsId = null)
    {
        $userKey = self::getExistingKey($session, $dsId);
        //trace_log($userKey->toArray());
        if (!$userKey) {
            //trace_log('création nouvelle clef');
            $userKey = new UserKey();
            $userKey->name = \Waka\Utils\Classes\TinyUuid::generate(5);
            if ($data_source = $session->data_source) {
                $data_source = \Datasources::find($data_source);
                $userKey->dseable_type = self::checkMorphMap($data_source->class);
                $userKey->dseable_id = $userKey->ds_id =  $dsId;
            }
            $userKey->data = $data;
            $userKey->key_end_at = $session->getEndKeyAt();
            $userKey->save();
            $session->user_keys()->add($userKey);
            return $userKey;
        }
        //trace_log('reutilisation de la clef');
        $userKey->data = $data;
        $userKey->key_end_at = $session->getEndKeyAt();
        $userKey->save();
        return $userKey;
    }

    public  static function getExistingKey(WakaSession $session, $dsId = null)
    {
        //trace_log('getExistingKey');
        if (!$dsId) return false;
        if (!$session->has_ds) return false;
        $data_source = $session->data_source;
        //trace_log($data_source);

        //trace_log('i ckeck');
        $today = \Carbon\Carbon::now();
        $query =  $session->user_keys()->where('ds_id', $dsId)->where('user_delete_key', false)->where('key_end_at', '>', $today->format('y-m-d'))
            ->whereHas('waka_session', function ($q) use ($data_source) {
                $q->where('data_source', $data_source);
            })->first();

        return $query;
    }

    public static function checkMorphMap($className, $name = false) {
        if(!$className) return;
        if (substr($className, 0, 1) === "\\") {
            $className = substr($className, 1);
        }
        $morphClassMaps = \Winter\Storm\Database\Relations\Relation::morphMap();
        foreach($morphClassMaps as $morphName=>$morphClass) {
            // trace_log($morphClass ."  ==  ".$className."  ==  ".$morphName);
            if($morphClass ==  $className)  {
                return $name ? $morphName : $morphClass;
            } else if($morphName ==  $className)  {
                return $name ? $morphName : $morphClass;
            } 
           
        }
         return $className;
    }


}
