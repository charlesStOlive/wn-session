<?php namespace Waka\Session\Models;

use Model;
use Carbon\Carbon;

/**
 * userKey Model
 */

class UserKey extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use \Waka\Utils\Classes\Traits\DataSourceHelpers;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'waka_session_user_keys';


    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id'];

    /**
     * @var array Fillable fields
     */
    //protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'name' => 'unique',
    ];

    public $customMessages = [
    ];

    /**
     * @var array attributes send to datasource for creating document
     */
    public $attributesToDs = [
        'finalUrl',
    ];


    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [
        'data',
    ];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [
        'key_name',
        'finalUrl',
    ];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [
        'secret',
        'ds_id',
        'dseable_id',
        'dseable_type',
    ];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'key_end_at',
    ];

/**
    * @var array Spécifié le type d'export à utiliser pour chaque champs
    */
    public $importExportConfig = [
    ]; 

    /**
     * @var array Relations
     */
    public $hasOne = [
    ];
    public $hasMany = [
    ];
    public $hasOneThrough = [
    ];
    public $hasManyThrough = [
    ];
    public $belongsTo = [
       'waka_session' => ['Waka\Session\Models\WakaSession'],
    ];
    public $belongsToMany = [
    ];        
    public $morphTo = [
        'dseable' => [],
    ];
    public $morphOne = [
    ];
    public $morphMany = [
    ];
    public $attachOne = [
        'file' => [
            'System\Models\File',
            'delete' => true
        ],
        'image' => [
            'System\Models\File',
            'delete' => true
        ],
    ];
    public $attachMany = [
        'files' => [
            'System\Models\File',
            'delete' => true
        ],
        'images' => [
            'System\Models\File',
            'delete' => true
        ],
    ];

    //startKeep/

    /**
     *EVENTS
     **/

    /**
     * LISTS
     **/
    public function listDurations()
    {
        return [];
    }

    /**
     * GETTERS
     **/
    public function getFinalUrlAttribute() {
        return  $this->waka_session->url.'/'.$this->name;
    }
    public function getkeyNameAttribute() {
        if($this->waka_session) {
            return $this->waka_session->name;
        } else {
            return null;
        }
        
    }
    public function getDataToStringAttribute() {
        if(!$this->data) {
            return '';
        }
        return \Yaml::render($this->data);
    }


    /**
     * SCOPES
     */

    /**
     * SETTERS
     */
 
    /**
     * FILTER FIELDS
     */

    /**
     * OTHERS
     */
    public function getValideAttribute()
    {
        if ($this->user_delete_key) {
            return false;
        }
        if ($this->key_end_at < Carbon::now()) {
            return false;
        } else {
            return true;
        }
    }
    

//endKeep/
}