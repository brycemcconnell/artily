<div class="board_sorter box bb3">
  <div>
    <button id="list_view" class="board_sorter-btn board_sorter-btn--active" title="List View"><?= $SVG->list(); ?></button>
    <button id="grid_view" class="board_sorter-btn" title="Grid View"><?= $SVG->grid(); ?></button>
  </div>
  <form action="" method="GET">
    
    <span>Sort by: </span>
    
    <select name="sort">
      <option value="trending">Trending</option>
      <option value="hearts">Most hearts</option>
      <option value="comments">Most comments</option>
      <option value="new">Newest</option>
      <option value="old">Oldest</option>
    </select>
    <input type="submit">
  </form>
  <script>
    var boardSorter = true;
  </script>
</div>