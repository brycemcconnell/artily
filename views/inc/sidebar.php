<!-- 

Change sidebar width to fixed 60px, and when expanding float over the grid so that
the layout doesnt change

 -->
 <?php
$collections = [
    [
        "name" => "cats"
    ],
    [
        "name" => "dogs"
    ]
];
$boards = [
	[
        "name" => "kittens"
    ],
    [
        "name" => "cats"
    ],
    [
        "name" => "puppers"
    ],
];
 ?>

<aside class="sidebar">

	<button type="button" class="sidebar-toggle_btn theme-btn" onclick="toggleSidebar();">
		<img class="sidebar-toggle_btn-img" src="/public/assets/img/sidebar.svg">
	</button>
	<div class="sidebar-content sidebar-content_small bb2">
		<div class="sidebar-section">
			<ul>
				<li><a class="sidebar-common_link sidebar-link" href="/?view=home"><span class="sidebar-icon"><?= $SVG->home('#d33'); ?></span><span class="sidebar-expanded"> Home</span></a></li>
				<li><a class="sidebar-common_link sidebar-link" href="/?view=trending"><span class="sidebar-icon"><?= $SVG->trend('#d33'); ?></span><span class="sidebar-expanded"> Trending</span></a></li>
				<li><a class="sidebar-common_link sidebar-link" href="/?view=all"><span class="sidebar-icon"><?= $SVG->globe('#d33'); ?></span><span class="sidebar-expanded"> All</span></a></li>
			</ul>
		</div>
		<div class="sidebar-section sidebar-expanded">
			<div class="sidebar-subtitle_container">
				<div class="sidebar-subtitle">Collections (<?= count($collections); ?>)</div>
				<button type="button" onclick="toggleSection('sidebarCollections')" class="theme-btn btn-tiny"><?= $SVG->arrow_down("#fff"); ?></button>
			</div>
			<ul class="sidebar-section_list" id="sidebarCollections">
				<?php foreach($collections as $c): ?>
				<li><a class="sidebar-link" href="/collection/<?= $c["name"]; ?>"><?= $c["name"]; ?></a></li>
				<?php endforeach; ?>
			</ul>
			<a href="collection?action=new" class="sidebar-create theme-btn theme-a-btn">Create New</a>
		</div>
		<div class="sidebar-section sidebar-expanded">
			<div class="sidebar-subtitle_container">
				<div class="sidebar-subtitle">Artboards (<?= count($boards); ?>)</div>
				<button type="button" onclick="toggleSection('sidebarArtboards')" class="theme-btn btn-tiny"><?= $SVG->arrow_down("#fff"); ?></button>
			</div>
			<ul class="sidebar-section_list" id="sidebarArtboards">
				<?php foreach($boards as $b): ?>
				<li><a class="sidebar-link" href="/board/<?= $b["name"]; ?>"><?= $b["name"]; ?></a></li>
				<?php endforeach; ?>
			</ul>
			<a href="board?action=new" class="sidebar-create theme-btn theme-a-btn">Create New</a>
		</div>
	</div>
	<script>
		function toggleSidebar() {
			// document.querySelectorAll('.sidebar-expanded').forEach(item => {
			// 	item.classList.toggle('none');
			// });
			document.querySelector('.sidebar-content').classList.toggle('sidebar-content_small');
		}

		function toggleSection(section) {
			document.getElementById(section).classList.toggle('none');
		}
	
	</script>
</aside>