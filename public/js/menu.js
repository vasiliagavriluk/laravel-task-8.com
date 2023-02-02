$(document).ready(function()
{
    var menuState = 0;

    function init() {
        contextListener();
        clickListener();
        keyupListener();
    }

    function clickInsideElement(e, className) {
        var el = e.srcElement || e.target;
        if (el.classList.contains(className)) {
            return el;
        } else {
            while (el = el.parentNode) {
                if (el.classList && el.classList.contains(className)) {
                    return el;
                }
            }
        }

        return false;
    }

    function keyupListener() {
        window.onkeyup = function (e) {
            if (e.keyCode === 27) {
                toggleMenuOff();
            }
        }
    }

    function clickListener() {
        document.addEventListener("click", function (e) {
            var button = e.which || e.button;
            if (button === 1) {
                menuState = 0;
                $(".context-menu").remove();
            }
        });
    }

    function contextListener() {
        document.addEventListener("contextmenu", function (e) {
            if (clickInsideElement(e, 'files-list')) {
                e.preventDefault();
                var name = e.target.innerText;
                //childNodes[0].data;
                var path = "disk:/Task_8/"+ e.target.dataset.path;
                toggleMenuOn(name, path);
            } else {
                menuState = 0;
                $(".context-menu").remove();
            }
        });
    }

    function toggleMenuOn(name, path) {

        if (menuState !== 1) {
            menuState = 1;

            var x = event.clientX + document.documentElement.scrollLeft;
            var y = event.clientY + document.documentElement.scrollTop;

            // Создаем меню:
            $('<div/>', {
                class: 'dropdown-menu cm-bottom context-menu context-menu--active', // Присваиваем блоку наш css класс контекстного меню:
                id: 'contextmenu'
            })
                .css({
                    left: x + 'px', // Задаем позицию меню на X
                    top: y + 'px' // Задаем позицию меню по Y
                })
                .appendTo('body')
                .append
                (
                    $('<h6/>', {class: 'dropdown-header'})
                        .append('<svg viewBox="0 0 24 24" class="svg-icon svg-archive"><path class="svg-path-archive"></path></svg>' + name)
                )
                .append(
                    $('<button/>', {class: 'dropdown-item','data-action':'view','data-name':name,'data-path':path})
                        .append('<span data-lang="show info" className="no-pointer">Показать информацию</span>'),
                    $('<div/>', {class: 'context-fm'})
                        .append('<button class="dropdown-item fm-action modal_upload-click" data-name="'+name+'" data-path="'+path+'" data-action="upload">' +
                            '<svg viewBox="0 0 24 24" class="svg-icon svg-tray_arrow_up">' +
                            '<path class="svg-path-tray_arrow_up"></path>' +
                            '</svg>' +
                            '<span data-lang="upload" class="no-pointer">Загрузить</span>' +
                            '</button>')
                        .append('<button class="dropdown-item fm-action" data-name="' + name + '" data-path="'+path+'" data-action="edit">\n' +
                            '    <svg viewBox="0 0 24 24" class="svg-icon svg-pencil_outline">\n' +
                            '        <path class="svg-path-pencil_outline"></path>\n' +
                            '    </svg>\n' +
                            '    <span data-lang="rename" class="no-pointer">Изменить</span>\n' +
                            '</button>')

                        .append('<button class="dropdown-item fm-action" data-name="' + name + '" data-path="' + path + '"  data-action="delete">\n' +
                            '    <svg viewBox="0 0 24 24" class="svg-icon svg-close_thick">\n' +
                            '        <path class="svg-path-close_thick"></path>\n' +
                            '    </svg>\n' +
                            '    <span data-lang="delete" class="no-pointer">Удалить</span>\n' +
                            '</button>')
                )

                .show('fast');
        } else {
            menuState = 0;
            $(".context-menu").remove();
        }
    }

    $(document).mouseup( function(e){ // событие клика по веб-документу
        var div = $( ".context-menu" ); // тут указываем ID элемента
        if ( !div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0 ) { // и не по его дочерним элементам
            div.remove(); // скрываем его
        }
    });

    init();
})
