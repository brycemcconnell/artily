<!-- 

Change sidebar width to fixed 60px, and when expanding float over the grid so that
the layout doesnt change

 -->

<aside class="sidebar">

	<button type="button" class="sidebar-toggle_btn theme-btn" onclick="toggleSidebar();">
		<img class="sidebar-toggle_btn-img" src="/public/assets/img/sidebar.svg">
	</button>
	<div class="sidebar-content sidebar-content_small bb2">
		<div class="sidebar-section">
			<ul>
				<li><a class="sidebar-common_link sidebar-link" href="index?view=home"><span class="sidebar-icon"><?= $SVG->home('#d33'); ?></span><span class="sidebar-expanded"> Home</span></a></li>
				<li><a class="sidebar-common_link sidebar-link" href="index?view=trending"><span class="sidebar-icon"><?= $SVG->trend('#d33'); ?></span><span class="sidebar-expanded"> Trending</span></a></li>
				<li><a class="sidebar-common_link sidebar-link" href="index?view=all"><span class="sidebar-icon"><?= $SVG->globe('#d33'); ?></span><span class="sidebar-expanded"> All</span></a></li>
			</ul>
		</div>
		<div class="sidebar-section sidebar-expanded">
			<div class="sidebar-subtitle_container">
				<div class="sidebar-subtitle">Collections (10)</div>
				<button type="button" onclick="toggleSection('sidebarCollections')" class="theme-btn btn-tiny"><?= $SVG->arrow_down("#fff"); ?></button>
			</div>
			<ul class="sidebar-section_list" id="sidebarCollections">
				<li><a class="sidebar-link" href="">Traditional Art</a></li>
				<li><a class="sidebar-link" href="">Contemporary Art</a></li>
				<li><a class="sidebar-link" href="">Video Games</a></li>
				<li><a class="sidebar-link" href="">User Interface</a></li>
				<li><a class="sidebar-link" href="">Design</a></li>
				<li><a class="sidebar-link" href="">Furniture</a></li>
				<li><a class="sidebar-link" href="">Architecture</a></li>
				<li><a class="sidebar-link" href="">Web Design</a></li>
				<li><a class="sidebar-link" href="">3d Graphics</a></li>
				<li><a class="sidebar-link" href="">Fanart</a></li>
				<li><a class="sidebar-link" href="">Animated Gifs</a></li>
				<li><a class="sidebar-link" href="">Blender</a></li>
			</ul>
			<a href="collection?action=new" class="sidebar-create theme-btn theme-a-btn">Create New</a>
		</div>
		<div class="sidebar-section sidebar-expanded">
			<div class="sidebar-subtitle_container">
				<div class="sidebar-subtitle">Artboards (87)</div>
				<button type="button" onclick="toggleSection('sidebarArtboards')" class="theme-btn btn-tiny"><?= $SVG->arrow_down("#fff"); ?></button>
			</div>
			<ul class="sidebar-section_list" id="sidebarArtboards">
				<li><a class="sidebar-link" href="">Zelda</a></li>
				<li><a class="sidebar-link" href="">Pokemon</a></li>
				<li><a class="sidebar-link" href="">Starcraft</a></li>
				<li><a class="sidebar-link" href="">Anno</a></li>
				<li><a class="sidebar-link" href="">Minecraft</a></li>
				<li><a class="sidebar-link" href="">League of Legends</a></li>
				<li><a class="sidebar-link" href="">Mario Kart</a></li>
				<li><a class="sidebar-link" href="">Bomberman</a></li>
				<li><a class="sidebar-link" href="">Anno</a></li>
				<li><a class="sidebar-link" href="">Minecraft</a></li>
				<li><a class="sidebar-link" href="">League of Legends</a></li>
				<li><a class="sidebar-link" href="">Starcraft</a></li>
				<li><a class="sidebar-link" href="">Anno</a></li>
				<li><a class="sidebar-link" href="">Mario Kart</a></li>
				<li><a class="sidebar-link" href="">Bomberman</a></li>
				<li><a class="sidebar-link" href="">Anno</a></li>
				<li><a class="sidebar-link" href="">Minecraft</a></li>
				<li><a class="sidebar-link" href="">League of Legends</a></li>
				<li><a class="sidebar-link" href="">Starcraft</a></li>
				<li><a class="sidebar-link" href="">Anno</a></li>
				<li><a class="sidebar-link" href="">Minecraft</a></li>
				<li><a class="sidebar-link" href="">League of Legends</a></li>
				<li><a class="sidebar-link" href="">Mario Kart</a></li>
				<li><a class="sidebar-link" href="">Bomberman</a></li>
				<li><a class="sidebar-link" href="">Anno</a></li>
				<li><a class="sidebar-link" href="">Minecraft</a></li>
				<li><a class="sidebar-link" href="">League of Legends</a></li>
				<li><a class="sidebar-link" href="">Mario Kart</a></li>
				<li><a class="sidebar-link" href="">Bomberman</a></li>
				<li><a class="sidebar-link" href="">Zelda</a></li>
				<li><a class="sidebar-link" href="">Pokemon</a></li>
				<li><a class="sidebar-link" href="">Starcraft</a></li>
				<li><a class="sidebar-link" href="">Anno</a></li>
				<li><a class="sidebar-link" href="">Minecraft</a></li>
				<li><a class="sidebar-link" href="">League of Legends</a></li>
				<li><a class="sidebar-link" href="">Mario Kart</a></li>
				<li><a class="sidebar-link" href="">Bomberman</a></li>
				<li><a class="sidebar-link" href="">Zelda</a></li>
				<li><a class="sidebar-link" href="">Pokemon</a></li>
				<li><a class="sidebar-link" href="">Starcraft</a></li>
				<li><a class="sidebar-link" href="">Anno</a></li>
				<li><a class="sidebar-link" href="">Minecraft</a></li>
				<li><a class="sidebar-link" href="">League of Legends</a></li>
				<li><a class="sidebar-link" href="">Mario Kart</a></li>
				<li><a class="sidebar-link" href="">Bomberman</a></li>
				<li><a class="sidebar-link" href="">Zelda</a></li>
				<li><a class="sidebar-link" href="">Pokemon</a></li>
				<li><a class="sidebar-link" href="">Starcraft</a></li>
				<li><a class="sidebar-link" href="">Anno</a></li>
				<li><a class="sidebar-link" href="">Minecraft</a></li>
				<li><a class="sidebar-link" href="">League of Legends</a></li>
				<li><a class="sidebar-link" href="">Mario Kart</a></li>
				<li><a class="sidebar-link" href="">Bomberman</a></li>
			</ul>
			<a href="artboard?action=new" class="sidebar-create theme-btn theme-a-btn">Create New</a>
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