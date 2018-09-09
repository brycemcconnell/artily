<div class="board_sorter">
  <button id="list_view" class="board_sorter-btn board_sorter-btn--active" title="List View"><?= $SVG->list(); ?></button>
  <button id="grid_view" class="board_sorter-btn" title="Grid View"><?= $SVG->grid(); ?></button>
  <script>
    const listView = document.getElementById('list_view');
    const gridView = document.getElementById('grid_view');
    const main = document.getElementById('main');
    listView.onclick = function() {
      main.className = 'grid grid--list';
      listView.className = "board_sorter-btn board_sorter-btn--active";
      gridView.className = "board_sorter-btn";
    }
    gridView.onclick = function() {
      main.className = 'grid';
      listView.className = "board_sorter-btn";
      gridView.className = "board_sorter-btn board_sorter-btn--active";
    }
  </script>
</div>