<?php

namespace Waka\Session\Classes\Traits;

use Exception;
use Waka\Session\Models\UserKey;
use Waka\Session\Models\WakaSession;
use Yaml;

trait WakaSessionTrait
{
    /**
     * 
     */
    public function getCachedSessionDatax($slug, $key = null) {
        $cacheCode = $this->getSessionCacheCode($slug, $key);
        $session =  \Cache::remember($cacheCode, 10,  function() use($key) {
            //trace_log($key);
            return $this->getWakaSessionData($key);
        });
        // $session = $this->getWakaSessionData($key);
        //trace_log($session);
        return $session;
    }
    

    /**
     * 
     */
    public function getSessionCacheCode($slug, $key) {
        return $slug.'_'.$key;
    }


    /**
     * 
     */
    public function getWakaSessionData($key = null)
    {
        //trace_log('session-------------------------------------------------- ');
        if (!$this->waka_session) {
            return [];
        }
        $dataSource = null;
        $ds_id = null;
        //trace_log(" hasDs " . $this->waka_session->has_ds);
        if ($this->waka_session->has_ds) {
            //trace_log("session avec DS");
            $dataSource = \DataSources::find($this->waka_session->data_source);
        }
        if ($key) {
            $keyModel = UserKey::where('name', $key)->first();
            //trace_log($key);
            //trace_log($keyModel->toArray());
            $ds_id = $keyModel->ds_id;
        }
        $id_is_test = false;

        if (!$ds_id) {
            $ds_id = $this->waka_session->ds_id_test;
            $id_is_test = true;
        } 

        if ($dataSource && $ds_id) {
            $dataSource = $dataSource->getQuery($ds_id);
        } else {
            $dataSource = collect();
        }
        //trace_log(get_class($dataSource));
        $twiged = \Cache::remember('twig' . $ds_id, 1, function () use ($dataSource) {
            try {
                return \Twig::parse($this->waka_session->mapping, ['ds' => $dataSource]);
            } catch (\Exception $ex) {
                \Flash::error($ex->getMessage());
                return null;;
            }
        });
        $sessionData = [];
        try {
            //trace_log($twiged);
            if($twiged) {
                $parsed = Yaml::parse($twiged);
                $parsed['id_is_test'] = $id_is_test;
                $sessionData =  collect($parsed);
                $sessionData = $sessionData->merge($dataSource);
            }
            
            // trace_log($dataSource->toArray());
            // $dataSource = $dataSource->get()->merge($sessionData);
            // trace_log($dataSource->toArray());
        } catch (\Exception $ex) {
            \Flash::error($ex->getMessage());
        }

        if (!$key) {
            //console.log($sessionData);
            return  $sessionData;
        } else {
            $keyData = collect(UserKey::where('name', $key)->first()->data);
            return $sessionData->merge($keyData);
        }
    }
}
