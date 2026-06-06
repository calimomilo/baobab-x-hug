<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['company_name', 'address', 'contact_address', 'contact_name', 'email', 'phone'])]
class ContactForm extends Model
{
    //
}
