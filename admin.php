<?php

$this->on('admin.init', function() {

    if ($this->module('cockpit')->hasaccess('bootmanager', 'manage')) {

        // bind admin routes
        $this->bindClass('Bootmanager\\Controller\\Admin', 'bootmanager');

        // add settings entry
        $this->on('cockpit.view.settings.item', function () {
            $this->renderView('bootmanager:views/partials/settings.php');
        });

    }

});
