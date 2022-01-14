<label class="switch m-0">
    <input class="button-switch {{ empty($class) ? '' : $class }}"
           name="{{ empty($name) ? '' : $name }}"
           id="{{ empty($id) ? '' : $id }}"
           data-link="{{ empty($link) ? '' : $link }}"
           type="checkbox" {{ ($status == 1) ? 'checked' : '' }}>
    <span class="slider round-switch"></span>
</label>
