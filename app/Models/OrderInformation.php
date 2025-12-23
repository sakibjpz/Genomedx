<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderInformation extends Model
{
    protected $fillable = [
        'sales_phone',
        'sales_email',
        'support_phone',
        'support_hours',
        'company_address',
        'company_website',
        'contact_button_text',
        'contact_button_link',
        'show_sales_section',
        'show_support_section',
        'show_address_section',
    ];
    
    protected $casts = [
        'show_sales_section' => 'boolean',
        'show_support_section' => 'boolean',
        'show_address_section' => 'boolean',
    ];
    
    /**
     * Get the address with line breaks for HTML display
     */
    public function getFormattedAddressAttribute()
    {
        return nl2br(e($this->company_address ?? ''));
    }
    
    /**
     * Get website domain for display
     */
    public function getWebsiteDomainAttribute()
    {
        if (!$this->company_website) {
            return null;
        }
        
        $parsed = parse_url($this->company_website);
        return $parsed['host'] ?? $this->company_website;
    }
}