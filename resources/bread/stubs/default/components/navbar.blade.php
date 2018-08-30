                @can('Browse bread_model_strings')
                    <li{!! request()->is('bread_model_variables') ?  ' class="active"' : '' !!}><a href="{{ route('bread_model_variables') }}"><i class="fa fa-fw fa-link"></i> bread_model_strings</a></li>
                @endcan