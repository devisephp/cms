@extends('devise::admin.layouts.master')

@section('main')
	<div class="dvs-admin-container">
        <div class="dvs-admin-card" data-dvs-url="{{ URL::route('dvs-pages') }}">
            <div class="dvs-card-top">
                <div class="dvs-image-wpr">
                    <img src="{{ URL::asset('packages/devise/cms/img/default-images/user-icon.png') }}">
                </div>

                <div class="dvs-hex-wpr">
                    <div class="dvs-card-hex">
                        <div class="dvs-hex-text">
                            <p class="dvs-value">252</p>
                            <p>Total Pages</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dvs-card-bottom">
                <h3>Pages</h3>
                <p>Manage pages, set URLs, and page versions.</p>

                <div class="dvs-metrics-wpr">
                    <div class="dvs-metric"><span class="dvs-badge">33</span>Queue</div>
                    <div class="dvs-metric"><span class="dvs-badge purple">4</span>In Progress</div>
                </div>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="{{ URL::route('dvs-menus') }}">
            <div class="dvs-card-top">
                <div class="dvs-image-wpr">
                    <img src="{{ URL::asset('packages/devise/cms/img/default-images/user-icon.png') }}">
                </div>

                <div class="dvs-hex-wpr">
                    <div class="dvs-card-hex">
                        <div class="dvs-hex-text">
                            <p class="dvs-value">122</p>
                            <p>Available</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dvs-card-bottom">
                <h3>Menus</h3>
                <p>Manage menus and children items.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="{{ URL::route('admin-event-index') }}">
            <div class="dvs-card-top">
                <div class="dvs-image-wpr">
                    <img src="{{ URL::asset('packages/devise/cms/img/default-images/user-icon.png') }}">
                </div>

                <div class="dvs-hex-wpr">
                    <div class="dvs-card-hex">
                        <div class="dvs-hex-text">
                            <p class="dvs-value">4</p>
                            <p>Current Events</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dvs-card-bottom">
                <h3>Events</h3>
                <p>Manage events and venue information.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="{{ URL::route('dvs-users') }}">
            <div class="dvs-card-top">
                <div class="dvs-image-wpr">
                    <img src="{{ URL::asset('packages/devise/cms/img/default-images/user-icon.png') }}">
                </div>

                <div class="dvs-hex-wpr">
                    <div class="dvs-card-hex">
                        <div class="dvs-hex-text">
                            <p class="dvs-value">3</p>
                            <p>Users</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dvs-card-bottom">
                <h3>Users</h3>
                <p>Manage users and define group association(s).</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="{{ URL::route('dvs-groups') }}">
            <div class="dvs-card-top">
                <div class="dvs-image-wpr">
                    <img src="{{ URL::asset('packages/devise/cms/img/default-images/user-icon.png') }}">
                </div>

                <div class="dvs-hex-wpr">
                    <div class="dvs-card-hex">
                        <div class="dvs-hex-text">
                            <p class="dvs-value">4</p>
                            <p>Groups</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dvs-card-bottom">
                <h3>Groups</h3>
                <p>Manage groups and related details.</p>
            </div>
        </div>

        <div class="dvs-admin-card" data-dvs-url="{{ URL::route('dvs-languages') }}">
            <div class="dvs-card-top">
                <div class="dvs-image-wpr">
                    <img src="{{ URL::asset('packages/devise/cms/img/default-images/user-icon.png') }}">
                </div>

                <div class="dvs-hex-wpr">
                    <div class="dvs-card-hex">
                        <div class="dvs-hex-text dvs-double-line">
                            <p class="dvs-value">34</p>
                            <p>Active<br>Language</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dvs-card-bottom">
                <h3>Languages</h3>
                <p>Manage languages and set active languages.</p>
            </div>
        </div>
	</div>
@stop