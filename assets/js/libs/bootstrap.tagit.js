;(function($, undefined){
    
    var Tagit = function(element, options){
        var self = this;
        self.elem = $(element);
        self.options = $.extend({}, $.fn.tagit.defaults, options);
        self.tagList = $('<ul />');
        self.tagInput = null;
        self.availableTags = null;

        $.when(self.loadAvailableTags())
            .then(function(){
                self.buildList();
                self.bindEvents();
                self.bindTypeahead();

                //Make taglist and elem the same
                self.tagList = self.elem;
            });
        
    };

    Tagit.prototype = {
        constructor: Tagit,
        //Builds the new list for the tags
        buildList : function(){
            var self = this;
            this.elem.find('li').each(function(i, listItem){
                self.addTag($(listItem).html());
            });
            //Adds an empty tag for creating new ones
            this.addTagInput();
            //Replace previous list items with the new ones
            this.elem.html('').append(this.tagList.find('li'));
        },
        //Add a new tag to the list
        addTag : function(tagName){
            if(this.tagExists(tagName) || tagName === '') return false;
            if(!this.options.acceptNewTags && !this.isAvailable(tagName)) return false;
            
            this.options.beforeAdd();

            var tagRemoveBtn = $('<i />')
                .addClass('icon-remove')
                .addClass('tagit-btn-remove-tag');

            var tagLink = $('<a />')
                .html(tagName)
                .addClass('label label-info')
                .append(tagRemoveBtn);

            var tagHiddenInput = $('<input />')
                .attr('type', 'hidden')
                .attr('id', 'tag-'+tagName)
                .attr('name', this.options.inputName+'[]')
                .val(tagName);

            var listItem = $('<li />')
                .data('tag', tagName)
                .addClass('tagit-item')
                .append(tagLink)
                .append(tagHiddenInput);

            if(this.tagInput){
                listItem.insertBefore(this.tagInput.parent('li'));
                this.tagInput.removeClass('error').val('');
            }else{
                listItem.appendTo(this.tagList);
            }

            this.options.afterAdd();

            return listItem;
        },
        //Check if the tag already exists on the list
        tagExists : function(tagName){
            var self = this,
                exists = false;
            this.tagList.find('li').each(function(i, listItem){
                var li = $(listItem),
                    _tagName = li.data('tag') || li.html();
                if(_tagName.toLowerCase() == tagName.toLowerCase()){
                    exists = true;
                    self.tagInput.val('');
                    self.highlightItem(li);
                    return false;
                }
            });
            return exists;
        },
        isAvailable : function(tagName){
            return this.availableTags.indexOf(tagName)>=0;
        },
        //Creates the input for the new tags
        addTagInput : function(){
            this.tagInput = $('<input />')
                .attr('type', 'text')
                .attr('class','tagit-input-add-tag')
                .attr('placeholder',this.options.newTagInputText)
                .addClass('input-medium')
                .val('');
            this.tagList.append($('<li />').append(this.tagInput));
        },
        bindEvents : function(){
            var self = this;
            //New Tags
            this.elem.on('keydown', '.tagit-input-add-tag', function(e){
                var input = $(this);
                //Capture "enter" and "tab" keys
                if(e.keyCode == 9 || e.keyCode == 13){
                    e.preventDefault();
                    if(!self.addTag(input.val()))
                        input.addClass('error');
                }
            });
            this.elem.on('click', '.tagit-btn-remove-tag', function(e){
                var listItem = $(this).parents('li.tagit-item');
                listItem.remove();
                e.preventDefault();
            });
        },
        loadAvailableTags : function(){
            var self = this;
            if($.type(this.options.tagSource) === 'string'){
                //The tag source is an url so lets get those tags
                return $.getJSON(this.options.tagSource, function(data){
                    self.availableTags = data;
                });
            }else{
                this.availableTags = this.options.tagSource;
                return true;
            }
        },
        highlightItem : function(li){
            li.find('a').css('background-color','#BD362F');
            setTimeout(function(){li.find('a').attr('style','');},1300);
        },
        bindTypeahead : function(){
            var self = this;
            self.tagInput.typeahead({
                source:self.availableTags,
                minLength:self.options.minCharSuggestion,
                afterSelect: function(val){
                    self.addTag(val);
                }
            });
        }
    };
    
    $.fn.tagit = function(option){
        return this.each(function(){
            var $this = $(this),
                data = $this.data('tagit'),
                options = typeof option == 'object' && option;
            if(!data) $this.data('tagit', (data = new Tagit(this, options)));
            if(typeof option == 'string') data[option]();
        });
    };
    
    $.fn.tagit.defaults = {
        inputName                   : 'tags',
        tagSource                   : null,
        newTagInputText             : 'new tag',
        minCharSuggestion           : 1,
        acceptNewTags               : true,
        afterAdd                    : function(){},
        beforeAdd                   : function(){}
    };
    
    $.fn.tagit.Constructor = Tagit;

})(jQuery);