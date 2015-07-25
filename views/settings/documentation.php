
<div class="row">
<div class="col-sm-3">
    <div class="list-group" data-list-name="documentation-list">
        <a href="#introduction" role="tab" data-toggle="tab" class="list-group-item active">Introduction</a>
        <a href="#installation" role="tab" data-toggle="tab" class="list-group-item">Installation</a>
        <a href="#shortcodes" role="tab" data-toggle="tab" class="list-group-item">Shortcodes</a>
        <a href="#theming" role="tab" data-toggle="tab" class="list-group-item">Theming</a>
    </div>
</div>
<div class="col-sm-9">

<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="introduction">
    <p>
        The Vacation Rental Property Connector plugin by Gueststream, Inc. allows you to sync all of your vacation
        rental properties from HomeAway, Escapia, ISILink (First Resort, Property Plus, V12) , Barefoot, RNS (Resort
        Network), VRMGR, RTR and other property management software to your website allowing potential guests to search,
        sort, compare and book your rental properties right from your website.
    </p>
</div>
<div role="tabpanel" class="tab-pane" id="installation">
    <ol>
        <li>Download the plugin zip file from https://github.com/Gueststream-Inc/VRPConnector</li>
        <li>Extract the ZIP file in to the /wp-content/plugins/ directory</li>
        <li>Activate the plugin</li>
        <li>Update your permalink structure to the custom setting /%post_id%/%postname%/</li>
        <li>Using the admin menu navigate to the VRP submenu item API Key and enter your API Key found on the settings
            page of your Gueststream.net account.
        </li>
    </ol>
</div>
<div role="tabpanel" class="tab-pane" id="shortcodes">
    <h3>[vrpUnits]</h3>

    <p>Displays all your units on the page sorted by unit name ascending.</p>

    <h3>[vrpSearch]</h3>

    <p>Displays all units that meet the search criteria passed via the shortcode attributes.
        Any combination of the following attributes may be used to generate the resulting list of units:</p>

    <ul>
        <li>city</li>
        <li>state</li>
        <li>country</li>
        <li>sleeps</li>
        <li>max_adults</li>
        <li>postal_code</li>
        <li>province</li>
        <li>bedrooms</li>
        <li>bathrooms</li>
        <li>type</li>
        <li>area</li>
        <li>view</li>
        <li>location</li>
    </ul>

    <p>All search attributes filter down data which means every attribute must match for a unit to show up in the
        result. The following are attributes that can be used with comma delimited values to allow more than one match
        type for each of the following:</p>

    <ul>
        <li>ids</li>
        <li>slugs</li>
        <li>types</li>
    </ul>

    <p>Fuzzy Search for Unit Names and Types</p>

    <ul>
        <li>
            <strong>namelike</strong> Fuzzy match to unit names.
        </li>
        <li>
            <strong>typelike</strong> Fuzzy match to unit types.
        </li>
    </ul>

    <h4>Example</h4>

    <p>The following is an example that would display all your units with three bedrooms located in Denver, Colorado:
        <code>[vrpSearch bedrooms="3" city="Denver" state="CO"]</code></p>

    <h4>Fuzzy Unit Name Search</h4>

    <p>The following is an exmaple that would display all units whose name begins with "SnowRidge". If you have units
        named "SnowRidge 117" and "SnowRidge Queen" they would both show up in the result set using this short code.
        <code>[vrpSearch namelike="SnowRidge"]</code></p>

    <h4>Displaying multiple unit types</h4>

    <p>The following is an example that would display all your units in Colorado that match any of the following types:
        condo, villa, home. <code>[vrpSearch types="condo,villa,home" state="CO"]</code></p>

    <h4>Displaying multiple (specific) units by Page Slug</h4>

    <p>Page slugs are customizable names that translate to the last element on the permalink to any given unit. If your
        unit page is <a href="http://www.example.com/vrp/unit/hidden_hideaway_cabin">http://www.example.com/vrp/unit/hidden_hideaway_cabin</a>
        then the unit's page slug is hidden_hideaway_cabin. This value can be set in the admin panel @ gueststream.net
    </p>

    <p>The following is an example that would display all your units with the following page slugs: "Winter_Wonderful",
        "Beach_Dayz", "hidden_hideaway_cabin"
        <code>[vrpSearch slugs="Winter_Wonderful,Beach_Dayz,hidden_hideaway_cabin"]</code></p>

    <h4>Sorting / Ordering Results</h4>

    <p>To sort the results by a specific field use the sort attribute and to order the results by ascending or
        descending use the order attribute with the value of low for ascending and high for descending.</p>

    <p><code>[vrpSearch sort="Name" order="low" city="Denver" state="CO"]</code>
        Will display all units in Denver, Colorado and sort them by the unit name in ascending order.</p>

    <p><code>[vrpSearch sort="City" order="high" state="CO"]</code>
        Will display all units in Colorado and sort them by City name descending.</p>

    <h4>Excluding Results</h4>

    <p>You can optionally use an exclamation point before a value to denote "NOT". The following is an example that
        would display all units with three bedrooms located in Colorado but NOT in Denver</p>

    <p><code>[vrpSearch bedrooms="3" city="!Denver" state="CO"]</code></p>

    <h3>[vrpComplexes]</h3>

    <p>Displays a list of all Complexes. The sort order of and information displayed about complexes is managed in your
        Gueststream.net control panel.</p>

    <h3>[vrpSearchForm]</h3>

    <p>Displays the simple search form for searching units based on availability.</p>

    <h3>[vrpAdvancedSearchForm]</h3>

    <p>Displays the advanced search form for searching units based on availability plus all other criteria as enabled in
        your Gueststream.net control panel.</p>

    <h3>[vrpCompare]</h3>

    <p>Displays the unit comparison page to guests that have selected/saved units to compare. This is sometimes called
        'favorites' or 'saved' results.</p>

    <h3>[vrpSpecials]</h3>

    <p>Displays all available rental specials.</p>

    <h3>[vrpFeaturedUnit]</h3>

    <p>Displays one or more links to featured unit pages. This short code can be used with or without additional
        attributes. The Featured unit theme file is vrpFeaturedUnit.php for displaying a single featured unit link and
        vrpFeaturedUnits.php for displaying multiple featured unit links.</p>

    <ul>
        <li>
            <code>[vrpFeaturedUnit]</code> will display a single (random) featured unit link.
        </li>
        <li>
            <code>[vrpFeaturedUnit show=5]</code> Will display up to 5 (random) featured unit links.
        </li>
        <li>
            <code>[vrpFeaturedUnit field="City" value="Vail"]</code> Will display 1 featured unit link wherein the Unit
            is in the City of Vail.
        </li>
        <li>
            <code>[vrpFeaturedUnit field="View" value="Ocean Front" show=5]</code> Will display up to 5 featured unit
            links that have an Ocean Front View.
        </li>
    </ul>
</div>

<div role="tabpanel" class="tab-pane" id="theming">
    <p>The VRPConnector comes with a very bare theme not tailored to the specific needs of a single company, vacation
        rental property manager or owner. This requires that all new installs must be themed to match your company's
        marketing needs.</p>

    <h3>Copying the theme files</h3>

    <p>Do NOT edit the theme files in the plugin directory as they will be over-written when the plugin is updated!</p>

    <ol>
        <li>From within your wordpress theme directory create a directory named <code>vrp</code>. It should look
            something like this: <code>/wp-content/themes/your_theme_name/vrp/</code>
        </li>
        <li>Copy all the content in <code>VRPConnector_plugin_directory/themes/mountainsunset/</code> to your theme
            directories vrp folder <code>/themes/your_theme_name/vrp/</code>. You should now have all the theme files in
            the base of the vrp directory. For example: <code>/themes/your_theme_name/vrp/results.php</code>
        </li>
        <li>Begin customizing your theme files.</li>
    </ol>

    <h3>Theme Files Explained</h3>

    <h4>unit.php</h4>

    <p>Single unit display. All the data available from your property management software is made available to this
        template page. The following information is generally made available to visitors:</p>

    <ul>
        <li>Unit Name</li>
        <li>Photo Gallery</li>
        <li>Description</li>
        <li>Availability calendar</li>
        <li>Rates (Seasonal)</li>
        <li>Check availability &amp; rate quote (this is usually how the guest will proceed to booking)</li>
        <li>Reviews</li>
        <li>and all other available unit metadata that you may want to present to the guest.</li>
    </ul>

    <h4>results.php</h4>

    <p>This displays the availability search results.</p>

    <h4>complex.php</h4>

    <p>Single complex display. Information regarding the complex itself and all the units within that complex is made
        available to this template page. Complexes are created and maintained from within the Gueststream.net
        account.</p>

    <h4>functions.php</h4>

    <p>All theme functions are located in this file.</p>

    <ul>
        <li>Pagination link functions</li>
        <li>Sorting link functions</li>
    </ul>

    <h4>booking.php</h4>

    <p>This is the wrapper for booking steps 1 through 3.</p>

    <h4>step1.php</h4>

    <p>Reservation rental agreement</p>

    <h4>step1a.php</h4>

    <p>optional package selection when packages are available. (often unused)</p>

    <h4>step2.php</h4>

    <p>Allows previous Guest login (often unused)</p>

    <h4>step3.php</h4>

    <p>Guest information and payment details</p>

    <h4>confirm.php</h4>

    <p>Booking placed &amp; order confirmation information displayed.</p>

    <h4>dobooking.php</h4>

    <h4>specials.php</h4>

    <p>Used to display a list of specials via vrp/specials/list</p>

    <h4>special.php</h4>

    <p>Used to display a single special via vrp/specials/%slug% or vrp/specials/%id% </p>

    <h4>Shortcode Specific</h4>

    <h4>>vrpUnits.php</h4>

    <p>Used to display the results from the [vrpUnits] shortcode.</p>

    <h4>vrpComplexes.php</h4>

    <p>Used to display the Complexes on the page where [vrpComplexes] shortcode is used.</p>

    <h4>vrpSearchForm.php</h4>

    <p>Currently this contains the search form that has yet to be wrapped by the [vrpSearchForm] shortcode although it
        soon will and is intended for use as a sidebar widget to begin or revise search results.</p>

    <h4>vrpAdvancedSearchForm.php</h4>

    <p>Used to display the content for the [vrpAdvancedSearchForm] shortcode.</p>

    <h4>vrpCompare.php</h4>

    <p>Used to display the unit comparisons on the page where [vrpCompare] shortcode is used.</p>

    <h4>vrpSpecials.php</h4>

    <p>Used to display the available specials on the page where [vrpSpecials] shortcode is used.</p>

    <h4>Insanity to be depreciated</h4>

    <h4>error.php</h4>

    <p>Displayed when we're trying to limp away from a mess.</p>

    <h4>print.php</h4>

    <p>Displayed when $_GET['printme'] is used.</p>

</div>

</div>