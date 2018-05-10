let sortUe = {

    initDraggableEntityRows: function () {
        let dragSrcEl = null;
        let startPosition = null;
        let endPosition = null;
        let parent = null;
        let entityId = null;

        function handleDragStart(e) {
            dragSrcEl = this;
            entityId = $(this).attr('rel');
            dragSrcEl.style.opacity = 0.4;
            parent = dragSrcEl.parentNode;
            startPosition = Array.prototype.indexOf.call(parent.children, dragSrcEl);
            console.log("start: "+startPosition);
            e.dataTransfer.setData('text/html', this.innerHTML);
            e.dataTransfer.effectAllowed = 'move';
            console.log(entityId);
        }

        function handleDragEnter (e) {
            //console.log("drag enter : "+e.target);
            this.classList.add('over');
        }

        function handleDragOver (e) {
            //console.log('drag over : '+e.target);
            e.preventDefault();
            e.stopPropagation();

            e.dataTransfer.dropEffect = 'move';

            return false;
        }

        function handleDragLeave (e) {
            //console.log('drag leave'+e.target);
            this.classList.remove('over');
        }

        function handleDrop (e) {
            //console.log('drop: '+ e.target);

            if (e.stopPropagation) {
                e.stopPropagation();
            }

            if (dragSrcEl != this) {
                endPosition = Array.prototype.indexOf.call(parent.children, this);
                if (endPosition >= 0) {
                    console.log("end : "+endPosition);
                    dragSrcEl.innerHTML = this.innerHTML;
                    this.innerHTML = e.dataTransfer.getData('text/html');

                    let tables = document.querySelectorAll('table.sortable');
                    let index = Array.prototype.indexOf.call(tables, parent.parentElement);

                    endPosition = endPosition+1;

                    $.ajax({
                        url: '/choixUe/position/'+entityId+'/'+endPosition,
                    }).done(function (res) {
                        $("table.sortable tbody").eq(index).replaceWith($(res).find("table.sortable tbody").eq(index));
                    }).fail(function () {
                        console.log('error');
                    }).always(function () {
                        sortUe.initDraggableEntityRows();
                    });
                }
            }

            return false;
        }

        function handleDragEnd (e) {
            this.style.opacity = 1;
            [].forEach.call(rows, function (row) {
                row.classList.remove('over');
            });
        }

        let rows = document.querySelectorAll('table.sortable > tbody tr');
        [].forEach.call(rows, function(row) {
            row.addEventListener('dragstart', handleDragStart, false);
            row.addEventListener('dragenter', handleDragEnter, false);
            row.addEventListener('dragover', handleDragOver, false);
            row.addEventListener('dragleave', handleDragLeave, false);
            row.addEventListener('drop', handleDrop, false);
            row.addEventListener('dragend', handleDragEnd, false);
        });
    },

    /**
     * Initialisation
     * @returns {boolean}
     */
    init: function () {
        this.initDraggableEntityRows();

        return true;
    }

};

$(function() {
    sortUe.init();
});
