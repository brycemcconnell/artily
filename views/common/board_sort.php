<div class="board_sorter box bb3">
  <div class="board_sorter-views">
    <button id="list_view" class="board_sorter-btn board_sorter-btn--active" title="List View"><?= $SVG->list(); ?></button>
    <button id="grid_view" class="board_sorter-btn" title="Grid View"><?= $SVG->grid(); ?></button>
  </div>
  <form action="" method="GET" class="board_sorter-form">
    
    <span class="board_sorter-label">Sort by: </span>
    
    <select id="boardSorterSelector" name="sort" class="board_sorter-select">
      <option value="trending">Trending</option>
      <option value="hearts">Most hearts</option>
      <option value="comments">Most comments</option>
      <option value="new">Newest</option>
      <option value="old">Oldest</option>
    </select>
    <input class="board_sorter-submit" type="submit" value="Go">
  </form>
  <script>
    window.onload = function() {
    var boardSorter = true;
      if (boardSorter) {
        console.log('ok');
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

        const boardSelector = document.getElementById('boardSorterSelector');
        boardSelector.onchange = function() {
          this.form.submit();
        }
      }
    }
  </script>
</div>