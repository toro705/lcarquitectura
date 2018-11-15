<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade" id="{%=file.id%}">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Procesando...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </td>
            <td>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-warning btn-flat start" disabled>
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Iniciar</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-default btn-flat cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancelar</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade" id="{%=file.id%}">
            <td>
                <span class="preview">
                {% if (file.thumbnailUrl) { %}
                <a href="{%=file.url%}" data-name="{%=file.name%}" data-id="{%=file.id%}" data-x="{%=file.x%}" data-y="{%=file.y%}" data-x2="{%=file.x2%}" data-y2="{%=file.y2%}" data-width="{%=file.w%}" data-height="{%=file.h%}" rel="" class="" download="{%=file.name%}">
                <img src="{%=file.thumbnailUrl%}">
                </a>
                {% } %}
                </span>
            </td>
            <td>
                {% if (file.url) { %}
                    
                    {% if (file.deleteUrl) { %}
                        <input type="text" class="form-control fileName" name="name[{%=file.id%}]" data-id="{%=file.id%}" value="{%=file.label%}" placeholder="{% if (file.name == 'video') { %} Ingrese URL de Vimeo {% } else { %} Ingrese Nombre {% } %}" data-rule-required="true"/>
                    {% } %}
                    
                {% } %}

                {% if (file.error) { %}
                    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                {% } %}
            </td>
            <td>
                {% if (file.deleteUrl) { %}
                    <button class="btn btn-default btn-flat delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Eliminar</span>
                    </button>
                {% } else { %}
                    <button class="btn btn-default btn-flat cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancelar</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>