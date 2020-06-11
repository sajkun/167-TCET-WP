/*!
 * WPBakery Page Builder v6.0.0 (https://wpbakery.com)
 * Copyright 2011-2020 Michael M, WPBakery
 * License: Commercial. More details: http://go.wpbakery.com/licensing
 */

// jscs:disable
// jshint ignore: start

  window.ThemeCustomTab = window.VcBackendTtaViewInterface.extend({
    sortableSelector: "> [data-vc-tab]",
    sortableSelectorCancel: ".vc-non-draggable-container",
    sortablePlaceholderClass: "vc_placeholder-tta-tab",
    navigationSectionTemplate: null,
    navigationSectionTemplateParsed: null,
    $navigationSectionAdd: null,
    sortingPlaceholder: "vc_placeholder-tab vc_tta-tab",
    render: function() {
        return window.ThemeCustomTab.__super__.render.call(this),
        this.$navigation = this.$el.find("> .wpb_element_wrapper .vc_tta-tabs-list"),
        this.$sortable = this.$navigation,
        this.$navigationSectionAdd = this.$navigation.children(".vc_tta-tab:first-child"),
        this.setNavigationSectionTemplate(this.$navigationSectionAdd.prop("outerHTML")),
        vc_user_access().shortcodeAll("vc_tta_section") ? this.$navigationSectionAdd.addClass("vc_tta-section-append").removeAttr("data-vc-target-model-id").removeAttr("data-vc-tab").find("[data-vc-target]").html('<i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i>').removeAttr("data-vc-tabs").removeAttr("data-vc-target").removeAttr("data-vc-target-model-id").removeAttr("data-vc-toggle") : this.$navigationSectionAdd.hide(),
        this
    },
    setNavigationSectionTemplate: function(html) {
        this.navigationSectionTemplate = html,
        this.navigationSectionTemplateParsed = vc.template(this.navigationSectionTemplate, vc.templateOptions.custom)
    },
    getNavigationSectionTemplate: function() {
        return this.navigationSectionTemplate
    },
    getParsedNavigationSectionTemplate: function(data) {
        return this.navigationSectionTemplateParsed(data)
    },
    changeNavigationSectionTitle: function(modelId, title) {
        this.findNavigationTab(modelId).find("[data-vc-target]").text(title)
    },
    changeActiveSection: function(modelId) {
        window.ThemeCustomTab.__super__.changeActiveSection.call(this, modelId),
        this.$navigation.children("." + this.activeClass).removeClass(this.activeClass),
        this.findNavigationTab(modelId).addClass(this.activeClass)
    },
    notifySectionRendered: function(model) {
        var $element, title, $insertAfter, clonedFrom;
        window.ThemeCustomTab.__super__.notifySectionRendered.call(this, model),
        title = model.getParam("title"),
        $element = $(this.getParsedNavigationSectionTemplate({
            model_id: model.get("id"),
            section_title: _.isString(title) && 0 < title.length ? title : this.defaultSectionTitle
        })),
        model.get("cloned") ? (clonedFrom = model.get("cloned_from"),
        _.isObject(clonedFrom) && (($insertAfter = this.$navigation.children('[data-vc-target-model-id="' + clonedFrom.id + '"]')).length ? $element.insertAfter($insertAfter) : $element.insertBefore(this.$navigation.children(".vc_tta-section-append")))) : model.get("prepend") ? $element.insertBefore(this.$navigation.children(":first-child")) : $element.insertBefore(this.$navigation.children(":last-child"))
    },
    notifySectionChanged: function(model) {
        var title;
        window.ThemeCustomTab.__super__.notifySectionChanged.call(this, model),
        title = model.getParam("title"),
        _.isString(title) && title.length || (title = this.defaultSectionTitle),
        this.changeNavigationSectionTitle(model.get("id"), title),
        model.view.$el.find("> .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_element-name").removeClass("vc_element-move"),
        model.view.$el.find("> .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_element-name .vc-c-icon-dragndrop").hide()
    },
    makeFirstSectionActive: function() {
        var $tab;
        ($tab = this.$navigation.children(":first-child:not(.vc_tta-section-append)").addClass(this.activeClass)).length && this.findSection($tab.data("vc-target-model-id")).addClass(this.activeClass)
    },
    findNavigationTab: function(modelId) {
        return this.$navigation.children('[data-vc-target-model-id="' + modelId + '"]')
    },
    removeSection: function(model) {
        var $viewTab, $nextTab;
        ($viewTab = this.findNavigationTab(model.get("id"))).hasClass(this.activeClass) && (($nextTab = this.getNextTab($viewTab)).addClass(this.activeClass),
        this.changeActiveSection($nextTab.data("vc-target-model-id"))),
        $viewTab.remove()
    },
    renderSortingPlaceholder: function(event, currentItem) {
        var helper, currentItemWidth, currentItemHeight;
        return currentItemWidth = (helper = currentItem).width() + 1,
        currentItemHeight = currentItem.height(),
        helper.width(currentItemWidth),
        helper.height(currentItemHeight),
        helper
    }
})
