define([
    'Magento_Ui/js/modal/modal-component',
    'uiRegistry',
    'mageUtils',
    'underscore'
], function (Modal, uiRegistry, utils, _) {
    'use strict';

    return Modal.extend({
        defaults: {
            parent_id: null,
            attachUrl: '${ $.attachUrl }',
            modules: {
                attachedItemListing: '${ $.attachedItemListing }',
                searchItemListing: '${ $.searchItemListing }'
            }
        },
        /**
         * attachItem
         */
        attachItem: function () {

            var sel = this.searchItemListing().selections().getSelections().selected;
            if(sel.length > 0 && this.parent_id) {
                utils.ajaxSubmit({
                    url: this.attachUrl + "?parent_id=" + this.parent_id,
                    data: {ids: sel}
                }, {ajaxSaveType: 'simple'}).done(function (data) {
                    this.closeModal();
                    this.attachedItemListing().reload({
                        refresh: true
                    }); 
                }.bind(this));
            }
            return this;
        }
    });
});