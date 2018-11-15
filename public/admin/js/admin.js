var Admin = function () {
    var currentUriSegment = 2;
    var mixerApplication;
    var mixerAdmin;
    toastr.options = {
        'newestOnTop': true,
        'positionClass': 'toast-top-center',
        'timeOut': 0,
        'showMethod': 'slideDown'
    };
    return {
        baseUrl: function(url) {
            var url  = $('meta[name="baseUrl"]').data().baseUrl + 'admin/' + url;
            return url;
        },
        uriSegment: function (n) {
            segment = window.location.pathname.split('/');
            return segment[n];
        },
        preloader: function () {
            window.onload = function () {
                $('.preloader').remove();
                $('body').css('overflow', 'auto');
            };
        },
        iCheckBox: function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        },
        fixToolTip: function () {
            (function () {
                $.widget.bridge('uibutton', $.ui.button);
            });
        },
        submitPaginationNumber: function () {
            $('#numrows').change(function () {
                $(this).submit();
            });
        },
        submitUserStateFilter: function () {
            $('#state').change(function () {
                $(this).submit();
            });
        },
        submitForms: function () {
            $('.box-footer button[type="submit"]').click(function () {
                $('input, select').removeAttr('disabled');
                $('.submitForms').submit();
            });
        },
        formValidation: function () {
            if ($('.formValidation').length > 0) {
                $('.formValidation').each(function () {
                    var id = $(this).attr('id');
                    $("#" + id).validate({
                        ignore: ':hidden',
                        errorElement: 'span',
                        errorClass: 'help-block has-error',
                        errorPlacement : function (error, element) {
                            if (element.hasClass('video')) {
                                element.parent().append(error);
                            } else if (element.hasClass('option')) {
                                element.parents('.col-md-10').find('.option-error').append(error.html('Debe seleccionar una opción como válida.'));
                            } else {
                                element.after(error);
                            }
                        },
                        highlight: function (label) {
                            $(label).closest('.form-group').removeClass('has-error has-success').addClass('has-error');
                        },
                        success: function (label) {
                            label.addClass('valid').closest('.form-group').removeClass('has-error has-success').addClass('has-success');
                        },
                        onkeyup: function (element) {
                            $(element).valid();
                        },
                        onfocusout:function (element) {
                            $(element).valid();
                        },
                        invalidHandler: function(form, validator) {
                            $('html, body').animate({
                                scrollTop: $(validator.errorList[0].element).offset().top - (parseInt($('header').height()) + 40)
                            }, 1000);
                        }
                    });
                });
            }
        },
        removeAction: function () {
            $('.removeAction').click(function () {
                event.preventDefault();
                var url = $(this).attr('href');
                bootbox.confirm({
                    message: '¿Desea eliminar el registro?',
                    onEscape: true,
                    backdrop: true,
                    buttons: {
                        confirm: {
                            label: 'Eliminar',
                            className: 'btn-primary btn-flat'
                        },
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-default btn-flat'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            window.location = url;
                        }
                    }
                });
            });
        },
        viewAction: function () {
            $('.viewAction').click(function (event) {
                event.preventDefault();
                if (!$(this).hasClass('button')) {
                    if ($(this).children().last('b').html() == 0) {
                        return false;
                    }
                }
                var url = $(this).attr('href');
                $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                $('body').css('overflow', 'hidden');
                $.ajax({url}).done(function (result) {
                    $('.preloader').remove();
                    $('body').css('overflow', 'auto');
                    bootbox.dialog({
                        size: 'large',
                        title: ' ',
                        message: result,
                        onEscape: true,
                        backdrop: true,
                        buttons: {
                            cancel: {
                                label: 'Cerrar',
                                className: 'btn-primary btn-flat'
                            }
                        }
                    });
                });
            });
        },
        passwordChange: function () {
            $('#passwordChange').click(function () {
                $('.passwordChange').toggleClass('hidden');
            });
        },
        charactersCount: function () {
            $('input[maxlength], textarea[maxlength]').each(function() {
                var $this = $(this);
                var maxLength = parseInt($this.attr('maxlength'));
                $this.attr('maxlength', null);
                var el = $('<span class="help-block has-error text-right"> Caracteres restantes ' + maxLength + '</span>');
                el.insertAfter($this);
                $this.bind('keyup', function () {
                    var cc = $this.val().length;
                    el.text('Caracteres restantes ' + (maxLength - cc));
                });
            });
        },
        formWizard: function () {

            $('#course-wizard #course-form, #course-wizard #course-module-form').submit(function () {
                return false;
            });

            $('.nav-tabs > li a[title]').tooltip();
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                var $target = $(e.target);
                if ($target.parent().hasClass('disabled')) {
                    return false;
                }
            });

            $('.next-step').click(function (e) {
                var state = $(this).data('state');
                if ($(this).parents('form').valid()) {
                    var $active = $('.wizard .nav-tabs li.active');
                    $active.next().removeClass('disabled');
                    nextTab($active);
                    if ($(this).parents('form').is('#course-module-lesson-complete-form')) {
                        var courseForm = $('#course-form').serializeArray();
                        var courseModuleForm = $('#course-module-form').serializeArray();
                        var url = Admin.baseUrl(Admin.uriSegment(currentUriSegment) + '/create_wizard');
                        $.ajax({
                            url: url,
                            dataType: 'json',
                            method: 'post',
                            data : {
                                course: courseForm,
                                teachers: $('.select2').val(),
                                module: courseModuleForm,
                                state: state
                            }
                        }).done(function (response) {
                            if (response && response.success) {
                                $('#course-module-lesson-complete-form li.removeOnSuccess').remove();
                                var href = $('#course-module-lesson-complete-form li.hidden a').attr('href') + response.course_id;
                                $('#course-module-lesson-complete-form li.hidden a').attr('href', href);
                                $('#course-module-lesson-complete-form li.hidden').removeClass('hidden');
                            } else {
                                bootbox.alert('Ocurrio un problema guardando sus registros, por favor, intente nuevamenete');
                            }
                        });
                    }
                }
            });

            $('.prev-step').click(function (e) {
                var $active = $('.wizard .nav-tabs li.active');
                prevTab($active);
            });

            function nextTab(elem) {
                $(elem).next().find('a[data-toggle="tab"]').click();
            }
            function prevTab(elem) {
                $(elem).prev().find('a[data-toggle="tab"]').click();
            }
        },
        navActive: function () {
            var module = this.uriSegment(currentUriSegment);
            var type = this.uriSegment(currentUriSegment + 2);
            if (module = 'users') {
                module = module + '_' + type
            }
            $('.sidebar-menu > li[data-controller="'+module+'"]').addClass('active');
        },
        select2: function () {
            if ($('.select2').length) {
                if (typeof teachersSelected != 'undefined') {
                    var array = $.map(teachersSelected, function (value, index) {
                        return [value];
                    });
                    $('.select2').val(array);
                }
                $('.select2').select2();

                // $(document).on('click', '.select2', function () {
                //     var element = $(this);
                //     $.ajax({
                //         url: Admin.baseUrl('users/teachers'),
                //         dataType: 'json',
                //         method: 'post',
                //         success: function (response) {
                //             if (response && response.result) {
                //                 console.log(response.teachers);
                //                 // $.each(response.teachers, function(index, val) {
                //                 //     var newOption = new Option(index, val, true, true);
                //                 // });
                //                 // var newOption = new Option('New Option', 3);
                //                 // console.log('newState: ' + newOption);
                //                 // $('select.select2').append(newOption);
                //                 // $('.select2').select2();
                //                 // element.trigger('open');
                //                 // $('.select2').select2();
                //                 // element.select2('data', {id: 3, text: 'newOption'});
                //                 // $('.select2').html('').select2({data: [{id: '', text: ''}]});
                //                 // $('.select2').html('').select2({data: [
                //                 // {id: '', text: ''},
                //                 // {id: '1', text: 'Facebook'},
                //                 // {id: '2', text: 'Youtube'},
                //                 // {id: '3', text: 'Instagram'},
                //                 // {id: '4', text: 'Pinterest'}]});
                //                 // $('.select2-search__field').trigger('click');
                //             }
                //         }
                //     });
                // });
            }
        },
        ckeditor: function () {
            if ($('#ckeditor').length) {
                CKEDITOR.replace('ckeditor');
            }
        },
        vimeo: function () {
            var i = 0;
            if ($('.lesssonConcept').length) {
                var i = $('.lesssonConcept').length;
                $('.seconds').each(function (k, seconds) {
                    $(seconds).html(Admin.msToTime($(seconds).html()));
                });
                $('#videoAdd').html('Cambiar');
                $('#videoAdd').attr('disabled', 'disabled');
                $('.concept-info').addClass('hidden');
            }
            videoAdd = function () {
                var url = $('input[name="url"]').val();
                url = url.split('/');
                id = url[(url.length - 1)] + '?color=f26735';
                // https://player.vimeo.com/video/76979871
                // https://vimeo.com/76979871
                // https://vimeo.com/218234161
                var iframe = '<iframe class="full-width" src="https://player.vimeo.com/video/$1" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                var iframe = iframe.replace('$1', id);
                $('#video').html('').append(iframe);
                var iframe = document.querySelector('iframe');
                var player = new Vimeo.Player(iframe);
                $('#videoAdd').html('Cambiar');
                $('#videoAdd').attr('disabled', 'disabled');
                $('#conceptAdd').parent().parent().removeClass('hidden');

                $(document).on('click', '#conceptAdd', function() {
                    $('.concept-info').addClass('hidden');
                    player.getCurrentTime().then(function(seconds) {
                        var time = Admin.msToTime(seconds);
                        var concept = '<li class="form-group lesssonConcept">'+
                        '<input type="text" name="concepts['+i+']" placeholder="Ingrese nombre del Concepto" class="form-control video" data-rule-required="true"/>'+
                        '<input type="hidden" name="time['+i+']" value="' + seconds + '"/>'+
                        '<span class="seconds">' + time + '</span>'+
                        '<button type="button" class="btn btn-primary btn-flat pull-right view"><i class="fa fa-eye"></i></button>'+
                        '<button type="button" class="btn btn-default btn-flat pull-right delete"><i class="glyphicon glyphicon-trash"></i></button>'+
                        '</li>';
                        $('#concepts').append(concept);
                        $('input[name="concepts['+i+']"]').focus();
                        i++;
                        // seconds = the current playback position
                    }).catch(function(error) {
                        // an error occurred
                    });
                });

                $(document).on('click', '#concepts .delete', function () {
                    $(this).parents('li').remove();
                    if (!$('.lesssonConcept').length) {
                        $('.concept-info').removeClass('hidden');
                    }
                });

                $(document).on('click', '#concepts .view', function () {
                    var seconds = $(this).prev().prev().val();
                    player.setCurrentTime(seconds).then(function(seconds) {
                        // seconds = the actual time that the player seeked to
                    }).catch(function(error) {
                        switch (error.name) {
                            case 'RangeError':
                                // the time was less than 0 or greater than the video’s duration
                                break;

                            default:
                                // some other error occurred
                                break;
                        }
                    });
                });
            };
            if ($('input[name="url"]').val()) {
                videoAdd();
            }
            var currentVideo = $('input[name="url"]').val();
            $('#videoAdd').click(function (e) {
                e.stopPropagation();
                e.preventDefault();
                if (currentVideo != $('input[name="url"]').val() && $('.lesssonConcept').length > 0) {
                    bootbox.confirm({
                        message: 'Si cambia el video se eliminarán los conceptos destacados',
                        onEscape: true,
                        backdrop: true,
                        buttons: {
                            confirm: {
                                label: 'Confirmar',
                                className: 'btn-primary btn-flat'
                            },
                            cancel: {
                                label: 'Cancelar',
                                className: 'btn-default btn-flat'
                            }
                        },
                        callback: function (result) {
                            if (result) {
                                $('.lesssonConcept').remove();
                                $('.concept-info').removeClass('hidden');
                                videoAdd();
                                currentVideo = $('input[name="url"]').val();
                            }
                        }
                    });
                } else if (currentVideo != $('input[name="url"]').val() && $('.lesssonConcept').length == 0) {
                    videoAdd();
                    currentVideo = $('input[name="url"]').val();
                }
            });
            $('input[name="url"]').on('input', function () {
                if (currentVideo != $('input[name="url"]').val()) {
                    $('#videoAdd').removeAttr('disabled');
                } else {
                    $('#videoAdd').attr('disabled', 'disabled');
                }
            });
        },
        msToTime: function (duration) {
            var duration = Math.round(duration * 1000);
            var milliseconds = parseInt((duration%1000)/100)
                , seconds = parseInt((duration/1000)%60)
                , minutes = parseInt((duration/(1000*60))%60)
                , hours = parseInt((duration/(1000*60*60))%24);

            hours = (hours < 10) ? "0" + hours : hours;
            minutes = (minutes < 10) ? "0" + minutes : minutes;
            seconds = (seconds < 10) ? "0" + seconds : seconds;

            return hours + ":" + minutes + ":" + seconds;
        },
        questionAdd: function () {
            var questionNumber = 0;
            if ($('.lessonQuestion')) {
                var questionNumber = $('.lessonQuestion').length;
            }
            $(document).on('click', '.questionAdd', function () {
                var type = $(this).data('type');
                var question =  '<li class="form-group row lessonQuestion">'+
                                    '<div class="col-xs-7 col-md-10">'+
                                        '<input type="text" name="questions['+ questionNumber +']" placeholder="Ingrese la pregunta" class="form-control" data-rule-required="true"/>'+
                                        '<input type="hidden" name="types['+ questionNumber +']" value="'+ type +'"/>'+
                                    '</div>'+
                                    '<div class="col-xs-5 col-md-2">'+
                                        '<button type="button" data-toggle="tooltip" title="Eliminar pregunta" class="btn btn-default btn-flat pull-right delete">'+
                                            '<i class="glyphicon glyphicon-trash"></i>'+
                                        '</button>'+
                                        '<button type="button" data-toggle="tooltip" title="Agregar Respuesta" class="btn btn-default btn-flat pull-right questionOptionAdd" data-type="'+type+'" data-question="'+questionNumber+'" data-origin="true">'+
                                            '<i class="fa fa-plus"></i>'+
                                        '</button>'+
                                    '</div>'+
                                '</li>';
                $('#questions').append(question);
                $('input[name="questions['+questionNumber+']"]').focus();
                $('input[name="questions['+questionNumber+']"]').parents('.lessonQuestion').find('.questionOptionAdd').trigger('click').remove();
                questionNumber++;
            });
        },
        questionOptionAdd: function () {
            var optionNumber = 0;
            if ($('.questionOption')) {
                var optionNumber = $('.questionOption').length;
            }
            $(document).on('click', '.questionOptionAdd', function () {
                var type = $(this).data('type');
                var question = $(this).data('question');
                var option =    '<li class="mb-15 row questionOption">'+
                                    '<div class="col-md-10">'+
                                        '<div class="row">'+
                                            '<div class="col-xs-1 text-center mt-10">';
                if (type == 'radio') {
                    option +=                   '<input type="'+type+'" class="form-control option" name="answer['+question+']" value="'+optionNumber+'" data-rule-required="true"/>';
                } else {
                    option +=                   '<input type="'+type+'" class="form-control option" name="answer['+question+']['+optionNumber+']" value="'+optionNumber+'"/>';
                }
                option +=                   '</div>'+
                                            '<div class="col-xs-11 row">'+
                                                '<div class="form-group bm-0">'+
                                                    '<input type="text" name="option['+question+']['+optionNumber+']" placeholder="Ingrese respuesta" class="form-control answer" data-rule-required="true"/>'+
                                                '</div>'+
                                                '<div class="form-group bm-0 option-error"></div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-md-2 text-right">'+
                                        '<div class="btn-group">'+
                                            '<button type="button" data-toggle="tooltip" title="Agregar Respuesta" class="btn btn-default btn-flat questionOptionAdd" data-type="'+type+'" data-question="'+question+'">'+
                                                '<i class="fa fa-plus"></i>'+
                                            '</button>'+
                                            '<button type="button" data-toggle="tooltip" title="Eliminar respuesta" class="btn btn-default btn-flat delete"><i class="glyphicon glyphicon-trash"></i></button>'+
                                        '</div>'+
                                    '</div>'+
                                '</li>';
                if ($('#'+question).length) {
                    $(this).parents('.questionOption').after(option);
                } else {
                    $('button[data-question="'+question+'"]').parent().parent().after('<ul class="list-unstyled" id="'+question+'"></ul>');
                    if ($(this).data('origin')) {
                        $('ul#'+question).append(option);
                    } else {
                        $(this).parents('.questionOption').after(option);
                    }
                }
                if (!$(this).data('origin')) {
                    $('input[name="option['+question+']['+optionNumber+']"]').focus();
                }
                Admin.iCheckBox();
                optionNumber++;
            });
            $(document).on('keyup', '.answer', function (e) {
                if (e.keyCode == 13) {
                    $(this).parents('.questionOption').find('.questionOptionAdd').trigger('click');
                }
            });
        },
        questionRemove: function () {
            $(document).on('click', '.lessonQuestion .delete', function () {
                $(this).parents('.lessonQuestion').next('ul').remove();
                $(this).parents('.lessonQuestion').remove();
                $('.tooltip').hide();
            });
        },
        questionOptionRemove: function () {
            $(document).on('click', '.questionOption .delete', function () {
                $(this).parents('.questionOption').remove();
                $('.tooltip').hide();
            });
        },
        simpleFileUpload: function () {
            $('#simpleFileUpload').fileupload({
                url: this.baseUrl(this.uriSegment(currentUriSegment) + '/file_upload/'+ $('input[name="id"]').val()),
                dataType: 'json',
                done: function (e, data) {
                    if (data && data.result && data.result.message) {
                        $('#messages').html('');
                        $('<p/>').text(data.result.message).appendTo('#messages');
                    } else if (data && data.result && data.result.url) {
                        $('#files').html('');
                        $('#messages').html('');
                        $('<img class="img-responsive"/>').attr('src', data.result.url).appendTo('#files');
                        if ($('.imageCrop').length) {
                            $('.imageCrop').attr('href', data.result.url);
                            $('.imageCrop').attr('data-width', data.result.w);
                            $('.imageCrop').attr('data-height', data.result.h);
                            $('.imageCrop').attr('data-name', data.result.name);
                            $('.imageCrop').attr('data-x', 0);
                            $('.imageCrop').attr('data-y', 0);
                            $('.imageCrop').attr('data-x2', data.result.w);
                            $('.imageCrop').attr('data-y2', data.result.h);
                            if ($('#files img').length && $('#files img').attr('src').indexOf('default.png') < 1) {
                                // $('.imageCrop').removeClass('hidden');
                                $('.imageCrop').trigger('click');
                            }
                        }
                    }
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css('width', progress + '%');
                    if (progress == 100) {
                        setTimeout(function() {
                            $('#progress .progress-bar').css('width', 0 + '%');
                        }, 3000);
                    }
                },
                always: function() {
                    // $('#progress').css('width', 0);
                }
            }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
            if ($('#files img').length && $('#files img').attr('src').indexOf('default.png') < 1) {
                // $('.imageCrop').removeClass('hidden');
            }
        },
        fileUpload: function () {
            if($('#fileUpload').length) {
                // Append Body jquery.fileupload-ui.js <script></script>
                $('body').append('<script type="text/javascript" src="'+Admin.baseUrl('admin/plugins/jQuery-File-Upload/js/jquery.fileupload-ui.js').replace('admin/admin', 'public/admin')+'"></script>');
                // Create files
                $('#fileUpload').fileupload({
                    prependFiles: true,
                    autoUpload : true,
                    url        : Admin.baseUrl(Admin.uriSegment(currentUriSegment)+'/create_file/'+$('input[name=id]').val())
                }).bind('fileuploaddone', function (e, data) {
                    setTimeout(function() {
                        $('table.table tbody tr:first-child input[type="text"]').focus();
                    }, 300);
                    Admin.videoGetTitle();
                });
                // Order files
                $('#fileUpload').bind('fileuploadcompleted', function (e, data) {
                    Admin.videoGetTitle();
                    $('.fileupload-buttonbar .delete-all').removeClass('hidden');
                    $('table.table tbody').trigger('sortupdate');
                    $('table.table tbody').sortable({
                        items: 'tr',
                        revert: true,
                        update: function (event, ui) {
                            var order = $(this).sortable('toArray');
                            $.ajax({
                                url: Admin.baseUrl(Admin.uriSegment(currentUriSegment) + '/update_order'),
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    order: order
                                }
                            }).fail(function (error) {
                                
                            });
                        }
                    }).disableSelection();
                    $('.table .files.ui-sortable > tr > td').each(function () {
                        $(this).width($(this).width());
                    });
                    $('table.table tbody').on('sortupdate', function(event, ui) {
                        var order = $(this).sortable('toArray');
                        $.ajax({
                            url: Admin.baseUrl(Admin.uriSegment(currentUriSegment) + '/update_order'),
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                order: order
                            }
                        }).fail(function (error) {
                            
                        });
                    });
                });
                // Read files
                $('#fileUpload').addClass('fileupload-processing');
                $.ajax({
                    url: Admin.baseUrl(Admin.uriSegment(currentUriSegment)+'/read_files/'+$('input[name=id]').val()),
                    dataType: 'json',
                    context: $('#fileUpload')[0]
                }).always(function () {
                    $(this).removeClass('fileupload-processing');
                }).done(function (result) {
                    $(this).fileupload('option', 'done').call(this, $.Event('done'), {result: result});
                    if ($('.fileName').length) {
                        Admin.autoSaveFileName();
                    }
                    if ($('#fileUpload table tr td .delete').length > 0) {
                        $('.fileupload-buttonbar .delete-all').removeClass('hidden');
                    }
                });

                // Delete al files
                $('#fileUpload .delete-all').click(function () {
                    bootbox.confirm({
                        message: '¿Desea eliminar todos los archivos?',
                        onEscape: true,
                        backdrop: true,
                        buttons: {
                            confirm: {
                                label: 'Eliminar',
                                className: 'btn-primary btn-flat'
                            },
                            cancel: {
                                label: 'Cancelar',
                                className: 'btn-default btn-flat'
                            }
                        },
                        callback: function (result) {
                            if (result) {
                                $('#fileUpload table tr td .delete').trigger('click');
                                $('.fileupload-buttonbar .delete-all').addClass('hidden');
                            }
                        }
                    });
                });
            }  
        },
        fileName: function () {
            $(document).on('focusout', '.fileName', function () {
                Admin.SaveFileName();
                Admin.videoGetTitle();
            });
        },
        SaveFileName: function() {
            if ($('.fileName').length) {
                var files = [];
                $('.fileName').each(function (k, file) {
                    files.push({id: $(file).data('id'), name: $(file).val()});
                });
                url = Admin.baseUrl(Admin.uriSegment(currentUriSegment) + '/update_file_name');
                $.ajax({
                    url: url,
                    dataType: 'json',
                    method: 'post',
                    data : {
                        files: files
                    }
                }).fail(function (error) {
                    // toastr.error('Ocurrio un error actualizando su registro, contacte con el administrador.', '!Atención!');
                });
            }
        },
        autoSaveFileName: function () {
            if ($('.fileName').length) {
                setTimeout(function () {
                    Admin.SaveFileName();
                    Admin.autoSaveFileName();
                }, 15000);
            }
        },
        courseOrder: function () {
            if ($('#sortable').length) {

                $('#sortable').sortable({
                    connectWith: '#sortable',
                    tolerance: 'pointer',
                    cursor: 'move',
                    forcePlaceholderSize: true,
                    handle: '.fa-arrows',
                    update: function (event, ui) {
                        var positions = $(this).sortable('toArray').toString();
                        var id = ui.item[0].id;
                        url = Admin.baseUrl('course_modules/order');
                        $.ajax({
                            url: url,
                            dataType: 'json',
                            method: 'post',
                            data : {
                                positions: positions
                            }
                        }).fail(function (error) {
                            // toastr.error('Ocurrio un error actualizando su registro, contacte con el administrador.', '!Atención!');
                        });
                    }
                }).disableSelection();

                $('#sortable ul').sortable({
                    connectWith: '#sortable ul',
                    tolerance: 'pointer',
                    cursor: 'move',
                    cancel: 'span.clearfix',
                    forcePlaceholderSize: true,
                    handle: '.fa-arrows',
                    update: function (event, ui) {
                        var positions = $(this).sortable('toArray').toString();
                        var id = ui.item[0].id;
                        var module = event.target.id;
                        url = Admin.baseUrl('lessons/order');
                        $.ajax({
                            url: url,
                            dataType: 'json',
                            method: 'post',
                            data : {
                                positions: positions,
                                module: module,
                            }
                        }).fail(function (error) {
                            // toastr.error('Ocurrio un error actualizando su registro, contacte con el administrador.', '!Atención!');
                        });
                    }
                }).disableSelection();

                $('#sortable > ul').each(function () {
                    var positions = $(this).sortable('toArray').toString();
                    var module = $(this).attr('id');
                    var url = Admin.baseUrl('lessons/order');
                    $.ajax({
                        url: url,
                        dataType: 'json',
                        method: 'post',
                        data : {
                            positions: positions,
                            module: module,
                        }
                    });
                });

                $('#sortable').each(function () {
                    var positions = $(this).sortable('toArray').toString();
                    var url = Admin.baseUrl('course_modules/order');
                    $.ajax({
                        url: url,
                        dataType: 'json',
                        method: 'post',
                        data : {
                            positions: positions
                        }
                    });
                });
            }
        },
        formValidationAddedMethods: function () {
            $.validator.addMethod('vimeo', function( value, element ) {
                var vimeo = /^(https?:\/\/)?(.*)?vimeo\.com+\/+\d{1,}/,
                    vimeoEmbed = /^(https?:\/\/)?(.*)?player\.vimeo\.com+\/+video\/+\d{1,}/;
                return (value.match(vimeo) || value.match(vimeoEmbed)) ? RegExp.$1 : false;
            }, 'Debe ser un video de Vimeo válido');
        },
        menuToggle: function () {
            $('a.sidebar-toggle').click(function () {
                var state = 'sidebar-collapse';
                if ($('body').hasClass('sidebar-collapse')) {
                    state = '';
                }
                var url = Admin.baseUrl('dashboards/menu_toggle');
                $.ajax({
                    url: url,
                    dataType: 'json',
                    method: 'post',
                    data : {
                        state: state
                    }
                });
            });
        },
        ajaxSetup: function () {
            $.ajaxSetup({global:true, cache: false});
            $(document).ajaxStart(function () {
                $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                $('body').css('overflow', 'hidden');
            });
            $(document).ajaxStop(function () {
                $('.preloader').remove();
                $('body').css('overflow', 'auto');
            });
        },
        cropImage: function() {
            /*
             * -----------------------------------------------------------------
             * Lightbox "Fancybox" extended Crop functionality
             * -----------------------------------------------------------------
             */
            $('.fancybox').fancybox({
                margin      : [20, 40, 40, 40], 
                padding     : 0,
                openEffect  : 'elastic',
                closeEffect : 'elastic',
                nextEffect  : 'fade',
                prevEffect  : 'fade',
                openOpacity : true,
                openSpeed   : 500,
                closeSpeed  : 250,
                autoResize: false,
                fitToView: true,
                tpl : {
                    closeBtn : ''
                },
                helpers     : { 
                    overlay : {
                        closeClick: false
                    }
                },
                beforeLoad  : function() {
                    // update_crop();
                },
                afterShow   : function() {
                    $('.fancybox-overlay').append('<div class="actions"></div>');
                    $('.fancybox-overlay .actions').append('<div class="text-center mt-10"><a title="Cancelar" class="fancybox-item fancyboxClose btn btn-primary btn-flat" href="javascript:;">Cancelar</a><a title="Guardar" class="fancybox-item fancyboxSave btn btn-primary btn-flat" href="javascript:;">Guardar</a></div>');
                    /*
                     * -----------------------------------------------------------------
                     * Crop "Jcrop"
                     * -----------------------------------------------------------------
                     */
                    var image           = $(this.element);
                    var aspect_ratio    = $('input[name=aspect_ratio_x]').val() / $('input[name=aspect_ratio_y]').val();
                    if ($(image).attr('data-x')) {
                        $('.fancybox-image').Jcrop ({
                            boxWidth    : $('.fancybox-image').width(),
                            boxHeight   : $('.fancybox-image').height(),
                            trueSize    : [$(image).attr('data-width'), $(image).attr('data-height')],
                            // setSelect   : [$(image).attr('data-x'), $(image).attr('data-y'), $(image).attr('data-x2'), $(image).attr('data-y2')],
                            aspectRatio : aspect_ratio,
                            keySupport  : false,
                            onSelect    : function(coords) {
                                if (Math.round($(image).attr('data-x') ) == Math.round(coords.x)  &&
                                    Math.round($(image).attr('data-y') ) == Math.round(coords.y)  &&
                                    Math.round($(image).attr('data-x2')) == Math.round(coords.x2) &&
                                    Math.round($(image).attr('data-y2')) == Math.round(coords.y2) ) {
                                    $(image).attr('data-update', 1);
                                } else {
                                    $(image).attr('data-update', 0);
                                    $(image).attr('data-w',  coords.w);
                                    $(image).attr('data-h',  coords.h);
                                    $(image).attr('data-x',  coords.x);
                                    $(image).attr('data-y',  coords.y);
                                    $(image).attr('data-x2', coords.x2);
                                    $(image).attr('data-y2', coords.y2);
                                }
                            }
                        });
                    } else {
                        $('.fancybox-image').Jcrop ({
                            boxWidth    : $('.fancybox-image').width(),
                            boxHeight   : $('.fancybox-image').height(),
                            trueSize    : [$(image).attr('data-width'), $(image).attr('data-height')],
                            aspectRatio : aspect_ratio,
                            keySupport  : false,
                            onSelect    : function(coords) {
                                $(image).attr('data-w',  coords.w);
                                $(image).attr('data-h',  coords.h);
                                $(image).attr('data-x',  coords.x);
                                $(image).attr('data-y',  coords.y);
                                $(image).attr('data-x2', coords.x2);
                                $(image).attr('data-y2', coords.y2);
                                $(image).attr('data-update', 0);
                            }
                        });
                    }
                },
                beforeClose : function() {
                    // update_crop();
                }
            });
            $(document).on('click', '.fancyboxSave', function() {
                update_crop();
                $.fancybox.close();
            });
            $(document).on('click', '.fancyboxClose', function() {
                $.fancybox.close();
            });
            /*
             * -----------------------------------------------------------------
             * Update Crop
             * -----------------------------------------------------------------
             */
            function update_crop()
            {
                $('.fancybox').each(function() {
                    var data    = new Object();
                    data.w      = $(this).attr('data-w');
                    data.h      = $(this).attr('data-h');
                    data.x      = $(this).attr('data-x');
                    data.y      = $(this).attr('data-y');
                    data.x2     = $(this).attr('data-x2');
                    data.y2     = $(this).attr('data-y2');
                    data.name   = $(this).attr('data-name');
                    id          = $(this).attr('data-id');
                    var image   = $('a[data-id='+id+']');
                    $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                    $('body').css('overflow', 'hidden');
                    $.ajax ({
                        url             : Admin.baseUrl(Admin.uriSegment(currentUriSegment)+'/update_crop/'+id),
                        type            : 'POST',
                        dataType        : 'json',
                        data            : {
                            data        : data
                        }
                    }).done(function(data) {
                        if(data.result == 1) {
                            d = new Date();
                            image.attr('data-update', 1);
                            image.attr('data-x');
                            image.attr('data-y');
                            image.attr('data-x2');
                            image.attr('data-y2');
                            $('#files img').attr('src', $('.imageCrop').attr('href').replace('original', 'medium')+'?'+d.getTime());
                            $('.preloader').remove();
                            $('body').css('overflow', 'auto');
                        }
                    });
                });
            }
        },
        chatForm: function () {
            $('.chatForm input[type="file"]').on('change', function () {
                // console.log('change file');
                var fileName = $(this).val().substr($(this).val().lastIndexOf('\\') + 1);
                if (fileName.length) {
                    $(this).parents('.form-group').next('.form-group').children('.row').children('.file').html('').append('<span><i class="fa fa-paperclip"></i>'+fileName+'<a href="javascript:;" class="pull-right"><i class="fa fa-close"></i></a></span>');
                }
                $(this).focusout();
            });
            $(document).on('click', '.chatForm .file span a',function (e) {
                // console.log('clean file');
                $(this).parents('.form-group').prev('.form-group').find('input[type="file"]').val(null).clone(true);
                $(this).parents('.file').html('');
            });
            $('.chatForm .sendMessage').on('click', function () {
                // console.log('clean file');
                var form = $(this).parents('form');
                if (form.valid()) {
                    var button = $(this);
                    var id = $(this).parents('form').attr('id');
                    var element = $(this).parents('.mix');
                    var data = new FormData($('#'+id)[0]);
                    var url = Admin.baseUrl('forums/message/' + id);
                    $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                    $('body').css('overflow', 'hidden');
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data : data,
                        cache: false,
                        contentType: false,
                        processData: false
                    }).success(function (response) {
                        response = jQuery.parseJSON(response);
                        if (response && response.answer) {
                            $('.preloader').remove();
                            $('body').css('overflow', 'auto');
                            form.find('.file').html('');
                            form[0].reset();
                            var chatClass = 'right';
                            if (response.question.user_id == response.answer.user_id) {
                                // var chatClass = '';
                            }
                            if (response.question.forum_question_type_id == 3) {
                                var chatClass = 'right';   
                            }
                            var message =   '<button type="button" class="btn btn-box-tool removeAnswer pull-right" data-id="' + response.answer.id + '">'+
                                                '<i class="fa fa-times"></i>'+
                                            '</button>'+
                                            '<div class="direct-chat-msg ' + chatClass + '">'+
                                                '<div class="direct-chat-info clearfix">';
                            if (response.question.forum_question_type_id < 3) {
                                message +=          '<span class="direct-chat-name pull-right">'+
                                                        response.answer.user.first_name + ' ' + response.answer.user.last_name +
                                                    '</span>'+
                                                    '<span class="direct-chat-timestamp pull-left">'+
                                                        response.answer.created +
                                                    '</span>';
                            }
                                message +=      '</div>';
                                if (response.question.forum_question_type_id < 3) {
                                    message +=  '<img class="direct-chat-img" src="'+ Admin.baseUrl('public/app/images/users/' + response.answer.user.image).replace('admin/', '') +'"/>';
                                } else {
                                    message +=  '<img class="direct-chat-img" src="'+ Admin.baseUrl('public/app/images/users/default.png').replace('admin/', '') +'"/>';
                                }
                                                
                                message +=      '<div class="direct-chat-text">'+
                                                    response.answer.name;
                                                    if (response && response.name) {
                                message +=              '<div>'+
                                                            '<a href="'+ response.src +'" target="_blank" class="attached">'+
                                                                '<span><i class="fa fa-paperclip mr-10"></i>' + response.answer.file + '</span>'+
                                                            '</a>'+
                                                        '</div>';
                                                    }
                                message +=      '</div>'+
                                            '</div>';
                            form.parents('.box-body').find('.direct-chat-messages').append(message);
                            button.focusout();
                            if (element.hasClass('admin-open')) {
                                element.removeClass('admin-open');
                                element.addClass('admin-close');
                            } else {
                                element.removeClass('application-open');
                                element.addClass('application-close');
                            }
                        }
                    });
                }
            });
        },
        questionForumAdd: function () {
            $('.questionForumAdd').click(function () {
                var form = $('.newQuestion').clone();
                $(form).removeClass('hidden');
                $(form).find('textarea').removeAttr('maxlength');
                $(form).find('textarea').removeAttr('data-rule-rangelength');
                $(form).find('textarea').attr('data-rule-minlength', '2');
                $(form).find('textarea').attr('placeholder', 'Ingresá la pregunta');
                $(form).find('.box-footer').css('border-top', '0');
                $(form).find('.box-header').hide();
                // console.log(form);
                bootbox.dialog({
                    size: 'large',
                    title: 'Nueva Pregunta',
                    message: form,
                    onEscape: true,
                    backdrop: true,
                    buttons: {
                    }
                });
                Admin.chatForm();
                Admin.formValidation();
                Admin.charactersCount();
            });
            $(document).on('click', '.sendQuestion', function () {
                var form = $(this).parents('form');
                if (form.valid()) {
                    var data = new FormData(form[0]);
                    var url = Admin.baseUrl('forums/question');
                    $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                    $('body').css('overflow', 'hidden');
                    // console.log(data);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data : data,
                        cache: false,
                        contentType: false,
                        processData: false
                    }).success(function (response) {
                        response = jQuery.parseJSON(response);
                        if (response && response.id) {
                            // console.log(response);
                            $('.preloader').remove();
                            $('body').css('overflow', 'auto');
                            form.find('.file').html('');
                            form[0].reset();
                            bootbox.hideAll();
                            location.reload();
                        }
                    });
                }
            });
        },
        videoAdd: function () {
            $('.videoAdd').click(function (e) {
                $('#fileUpload').append('<input type="text" name="type" value="video"/>');
                $('#fileUpload').fileupload('add', {files: {}});
                $('#fileUpload input[name="type"]').remove();
            });
        },
        videoGetTitle: function () {
            if ($('a[download="video"]').length) {
                $('a[download="video"]').each(function (k, v) {
                    var element = $(this).parents('td').next('td');
                    var url = element.find('input').val();
                    url = url.split('/');
                    var id = url[(url.length - 1)] + '?color=f26735';
                    var iframe = '<iframe class="full-width hidden" id="'+k+'" src="https://player.vimeo.com/video/$1" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                    iframe = iframe.replace('$1', id);
                    element.find('iframe').remove();
                    element.append(iframe);
                    var src = $(iframe).attr('src');
                    var iframe = document.getElementById(k);
                    var player = new Vimeo.Player(iframe);
                    player.getVideoTitle().then(function(title) {
                        element.find('a').remove();
                        element.append('<a data-fancybox-type="iframe" href="'+src+'"  class="fancyboxIframe fancybox.iframe name mt-10">'+title+'</a>');
                        element.parent().find('a[download="video"]').attr({
                            'data-fancybox-type': 'iframe',
                            'href': src,
                            'class': 'fancyboxIframe'
                        });
                        element.parent().find('a[download="video"]').removeAttr('download');
                    }).catch(function(error) {
                        // console.log('error => ', error);
                    });
                });
            }
            $('.fancyboxIframe').fancybox({
                fitToView   : true,
                autoSize    : true,
                closeClick  : false,
                openEffect  : 'elastic',
                closeEffect : 'elastic'
            });
        },
        dropDownChat: function() {
            $('.direct-chat-primary .box-header .direct-chat-msg').click(function (e) {
                $(this).parents('.box-header').find('button[data-widget="collapse"]').trigger('click');
            });
        },
        coursePublish: function () {
            $('.coursePublish').click(function () {
                $('.tooltip').hide();
                var element = $(this),
                    state = element.data('state');
                $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                $('body').css('overflow', 'hidden');
                $.ajax({
                    url: Admin.baseUrl(Admin.uriSegment(currentUriSegment) + '/update_state/' + Admin.uriSegment(4)),
                    dataType: 'json',
                    method: 'post',
                    data: {
                        state: state
                    }
                }).always(function () {
                    $('.preloader').remove();
                    $('body').css('overflow', 'auto');
                }).done(function (result) {
                    if (result) {
                        if (state == 1) {
                            element.parents('.ml-20').find('.publish').addClass('hidden');
                            element.parents('.ml-20').find('.unpublish').removeClass('hidden');
                            element.parents('.ml-20').find('.state').html('Publicado');
                        } else {
                            element.parents('.ml-20').find('.unpublish').addClass('hidden');
                            element.parents('.ml-20').find('.publish').removeClass('hidden');
                            element.parents('.ml-20').find('.state').html('Borrador');
                        }
                    }
                });
            });
        },
        lessonAddPreload: function () {
            $('.dropdown-menu-lesson-add a').click(function () {
                $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, 1)"><h1>Cargando...</h1></div>');
                $('body').css('overflow', 'hidden');
            });
        },
        equalHeight(element) {
            element.removeAttr('style');
            var alto = 0;
            var altura = 0;
            element.each(function () {
                altura = $(this).height();
                if (altura > alto) {
                    alto = altura;
                }
            });
            element.height(alto);
            window.onresize = function () {
                setTimeout(function() {
                    // console.log('onresize');
                    Admin.equalHeight(element);
                }, 100);
            };
        },
        boxHeight: function () {
            if ($('div.box-1').length) {
                Admin.equalHeight($('div.box-1 ul.data h4'));
                Admin.equalHeight($('div.box-1 ul.data p'));
                Admin.equalHeight($('div.box-1'));
            }
        },
        forumQuestionRemove: function () {
            $(document).on('click', '#forum-detail button.remove', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var element = $(this),
                    id      = element.data('id');
                // console.log(id);
                bootbox.confirm({
                    message: '¿Desea eliminar la pregunta con todas sus respuestas?',
                    onEscape: true,
                    backdrop: true,
                    buttons: {
                        confirm: {
                            label: 'Eliminar',
                            className: 'btn-primary btn-flat'
                        },
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-default btn-flat'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                            $('body').css('overflow', 'hidden');
                            $.ajax({
                                url: Admin.baseUrl(Admin.uriSegment(currentUriSegment) + '/delete_question'),
                                dataType: 'json',
                                method: 'post',
                                data: {
                                    id: id
                                }
                            }).always(function () {
                                $('.preloader').remove();
                                $('body').css('overflow', 'auto');
                            }).done(function (result) {
                                if (result) {
                                    element.parents('.direct-chat').remove();
                                }
                            });
                        }
                    }
                });
            });
        },
        forumAnswerRemove: function () {
            $(document).on('click', '#forum-detail button.removeAnswer', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var element = $(this),
                    id      = element.data('id');
                // console.log(id);
                bootbox.confirm({
                    message: '¿Desea eliminar la respuesta?',
                    onEscape: true,
                    backdrop: true,
                    buttons: {
                        confirm: {
                            label: 'Eliminar',
                            className: 'btn-primary btn-flat'
                        },
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-default btn-flat'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                            $('body').css('overflow', 'hidden');
                            $.ajax({
                                url: Admin.baseUrl(Admin.uriSegment(currentUriSegment) + '/delete_answer'),
                                dataType: 'json',
                                method: 'post',
                                data: {
                                    id: id
                                }
                            }).always(function () {
                                $('.preloader').remove();
                                $('body').css('overflow', 'auto');
                            }).done(function (result) {
                                if (result) {
                                    element.next('.direct-chat-msg').remove();
                                    element.remove();
                                }
                            });
                        }
                    }
                });
            });
        },
        forumQuestionPrivate: function () {
            $(document).on('click', '.questionPrivate', function () {
                var element         = $(this),
                    data            = {
                        id:      element.data('id'),  
                        private: element.data('private')

                    };
                bootbox.confirm({
                    message: '¿Desea cambiar el estado de la pregunta?',
                    onEscape: true,
                    backdrop: true,
                    buttons: {
                        confirm: {
                            label: 'Aplicar',
                            className: 'btn-primary btn-flat'
                        },
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-default btn-flat'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                            $('body').css('overflow', 'hidden');
                            $.ajax({
                                url: Admin.baseUrl(Admin.uriSegment(currentUriSegment) + '/update_privacity'),
                                dataType: 'json',
                                method: 'post',
                                data: data
                            }).always(function () {
                                $('.preloader').remove();
                                $('body').css('overflow', 'auto');
                            }).done(function (result) {
                                if (result && result.success && result.private == 1) {
                                    element.data('private', 0).removeClass('btn-danger').addClass('btn-success').text('Pública').removeAttr('title').attr('data-original-title', 'Cambiar estado a Pública');
                                    element.parents('.box-title').find('strong').removeClass('green').addClass('red').text('Privada');
                                    if (element.parents('.mix').hasClass('application-all')) {
                                        element.parents('.mix').removeClass('application-public').addClass('application-private');
                                    } else {
                                        element.parents('.mix').removeClass('admin-public').addClass('admin-private');
                                    }
                                } else {
                                    element.data('private', 1).removeClass('btn-success').addClass('btn-danger').text('Privada').removeAttr('title').attr('data-original-title', 'Cambiar estado a Privada');
                                    element.parents('.box-title').find('strong').removeClass('red').addClass('green').text('Pública');
                                    if (element.parents('.mix').hasClass('application-all')) {
                                        element.parents('.mix').removeClass('application-private').addClass('application-public');
                                    } else {
                                        element.parents('.mix').removeClass('admin-private').addClass('admin-public');
                                    }
                                }
                                $('[data-toggle="tooltip"]').tooltip();
                            });
                        }
                    }
                });
            });
        },
        forumQuestionType: function () {
            $(document).on('click', '.questionType', function () {
                var element = $(this),
                    data    = {
                        id: element.data('id'),
                        type: element.data('type')
                    };
                console.log(data);
                console.log(element.parents('.mix').index());
                bootbox.confirm({
                    message: '¿Desea mover la pregunta de foro?',
                    onEscape: true,
                    backdrop: true,
                    buttons: {
                        confirm: {
                            label: 'Aceptar',
                            className: 'btn-primary btn-flat'
                        },
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-default btn-flat'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                            $('body').css('overflow', 'hidden');
                            $.ajax({
                                url: Admin.baseUrl(Admin.uriSegment(currentUriSegment) + '/update_type'),
                                dataType: 'json',
                                method: 'post',
                                data: data
                            }).always(function () {
                                $('.preloader').remove();
                                $('body').css('overflow', 'auto');
                            }).done(function (result) {
                                console.log(result);
                                if (result && result.success && result.type == 1) {
                                    var type_from = 'application',
                                        type_to   = 'admin',
                                        forum     = 'Plataforma',
                                        button    = 'Curso',
                                        title     = 'Mover a Foro Curso';
                                } else {
                                    var type_from = 'admin',
                                        type_to   = 'application',
                                        forum     = 'Curso',
                                        button    = 'Plataforma',
                                        title     = 'Mover a Foro Plataforma';
                                }
                                element.data('type', result.type).text(button).removeAttr('title').attr('data-original-title', title).parents('.pull-right').find('strong').text(forum);
                                element.parents('.mix').removeClass(type_from+'-all').addClass(type_to+'-all');
                                if (element.parents('.mix').hasClass(type_from+'-open')) {
                                    element.parents('.mix').removeClass(type_from+'-open').addClass(type_to+'-open');
                                }
                                if (element.parents('.mix').hasClass(type_from+'-close')) {
                                    element.parents('.mix').removeClass(type_from+'-close').addClass(type_to+'-close');
                                }
                                if (element.parents('.mix').hasClass(type_from+'-private')) {
                                    element.parents('.mix').removeClass(type_from+'-private').addClass(type_to+'-private');
                                }
                                if (element.parents('.mix').hasClass(type_from+'-public')) {
                                    element.parents('.mix').removeClass(type_from+'-public').addClass(type_to+'-public');
                                }
                                if (result && result.success && result.type == 1) {
                                    element.parents('.mix').prependTo('#admin > .tab-pane');
                                    mixerAdmin.forceRefresh();
                                    mixerAdmin.sort('created:asc');
                                    mixerAdmin.sort('created:desc');
                                } else {
                                    element.parents('.mix').prependTo('#application > .tab-pane');
                                    mixerApplication.forceRefresh();
                                    mixerApplication.sort('created:asc');
                                    mixerApplication.sort('created:desc');
                                }
                                $('[data-toggle="tooltip"]').tooltip();
                            });
                        }
                    }
                });
            });
        },
        forumNav: function () {
            if ($('#forum-detail').length) {

                if ($('[data-ref="containerApplication"]').length) {
                    var config = {
                        controls: {
                            scope: 'local',
                            toggleDefault: 'none'
                        },
                        selectors: {
                            control: '[data-mixitup-control]'
                        }
                    };
                    mixerApplication = mixitup('#application', config);
                    mixerAdmin = mixitup('#admin', config);
                }

                if (window.location.hash) {
                    var hash = window.location.hash,
                        parent = hash.split('-')[0],
                        hash = '.'+hash.split('#')[1];
                    $('a[href="'+ parent +'"]').tab('show');
                    $('button[data-filter="'+ hash +'"]').trigger('click');
                }
            }
        },
        disableLinks: function () {
            $('#forums-read a[href="javascript:;"], #curses a[href="javascript:;"]').each(function () {
                $(this).css({
                    'cursor':'default'
                });
                $('#forums-read a[href="javascript:;"], #curses a[href="javascript:;"]').mouseenter(function() {
                    $(this).css('background', '#f39c12').css('color', '#fff');
                }).mouseleave(function() {
                    $(this).css('background', '#f39c12').css('color', '#fff');
                });
            });
        },
        userCourse: function () {
            $('.asignCourseAction').click(function () {
                var user_id = $(this).data('user');
                console.log(user_id);
                $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                $('body').css('overflow', 'hidden');
                $.ajax({
                    url: Admin.baseUrl(Admin.uriSegment(currentUriSegment) + '/userCourse/' + user_id),
                    dataType: 'html',
                    method: 'post'
                }).always(function () {
                    $('.preloader').remove();
                    $('body').css('overflow', 'auto');
                }).done(function (result) {
                    bootbox.dialog({
                        size: 'medium',
                        title: 'Asignar Curso',
                        message: result,
                        onEscape: true,
                        backdrop: true,
                        buttons: {
                            cancel: {
                                label: 'Cerrar',
                                className: 'btn-primary btn-flat'
                            }
                        }
                    });
                });
            });

            $(document).on('change', 'select[name="course_id"]', function () {
                var element     = $(this),
                    course_id   = element.val();
                    button      = $('.addUserCourse');
                button.attr('disabled', 'disabled');
                if (course_id) {
                    button.removeAttr('disabled');
                }
            });

            $(document).on('click', '.addUserCourse', function () {
                var user_id = $(this).data('user');
                console.log(user_id);
                bootbox.confirm({
                    message: '¿Desea asignar el curso al usuario?',
                    onEscape: true,
                    backdrop: true,
                    buttons: {
                        confirm: {
                            label: 'Asignar',
                            className: 'btn-primary btn-flat'
                        },
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-default btn-flat'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            var course_id = $('select[name="course_id"]').val();
                            $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                            $('body').css('overflow', 'hidden');
                            $.ajax({
                                url: Admin.baseUrl(Admin.uriSegment(currentUriSegment) + '/userCourseCreate/' + user_id + '/' + course_id),
                                dataType: 'html',
                                method: 'post'
                            }).always(function () {
                                $('.preloader').remove();
                                $('body').css('overflow', 'auto');
                            }).done(function (result) {
                                $('.userCourse').html('');
                                $('.userCourse').html(result);
                            });
                        }
                    }
                });
            });

            $(document).on('click', '.deleteUserCourse', function () {
                var element = $(this);
                bootbox.confirm({
                    message: '¿Desea eliminar la asignación del curso al usuario?',
                    onEscape: true,
                    backdrop: true,
                    buttons: {
                        confirm: {
                            label: 'Eliminar',
                            className: 'btn-primary btn-flat'
                        },
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-default btn-flat'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            var user_id   = element.data('user'),
                                course_id = element.data('course');
                            console.log(course_id)
                            $('body').append('<div class="preloader" style="background:rgba(255, 255, 255, .4)"><h1>Cargando...</h1></div>');
                            $('body').css('overflow', 'hidden');
                            $.ajax({
                                url: Admin.baseUrl(Admin.uriSegment(currentUriSegment) + '/userCourseDelete/' + user_id + '/' + course_id),
                                dataType: 'html',
                                method: 'post'
                            }).always(function () {
                                $('.preloader').remove();
                                $('body').css('overflow', 'auto');
                            }).done(function (result) {
                                $('.userCourse').html('');
                                $('.userCourse').html(result);
                            });
                        }
                    }
                });
            });
        },
        init: function () {
            Admin.iCheckBox();
            Admin.fixToolTip();
            Admin.preloader();
            Admin.submitPaginationNumber();
            Admin.submitForms();
            Admin.formValidation();
            Admin.removeAction();
            Admin.viewAction();
            Admin.simpleFileUpload();
            Admin.passwordChange();
            Admin.charactersCount();
            Admin.formWizard();
            Admin.navActive();
            Admin.select2();
            Admin.ckeditor();
            Admin.vimeo();
            Admin.fileUpload();
            Admin.questionAdd();
            Admin.questionOptionAdd();
            Admin.questionRemove();
            Admin.questionOptionRemove();
            Admin.fileName();
            Admin.courseOrder();
            Admin.menuToggle();
            Admin.cropImage();
            Admin.chatForm();
            Admin.questionForumAdd();
            Admin.videoAdd();
            Admin.dropDownChat();
            Admin.coursePublish();
            Admin.lessonAddPreload();
            Admin.boxHeight();
            Admin.submitUserStateFilter();
            Admin.disableLinks();
            Admin.userCourse();
            Admin.formValidationAddedMethods();
            Admin.forumQuestionRemove();
            Admin.forumQuestionPrivate();
            Admin.forumQuestionType();
            Admin.forumAnswerRemove();
            Admin.forumNav();
        }
    }
}();

jQuery(document).ready(function () {
    Admin.init();
});
