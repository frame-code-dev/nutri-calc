<?php
use Illuminate\Support\Facades\Schema;
echo Schema::hasColumn('users', 'phone') ? 'Column exists' : 'Column missing';
