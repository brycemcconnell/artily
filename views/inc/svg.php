<?php 

class SVGFactory {

	/**
	 * 
	 */
	public function p(string $svg)
	{

	}

	public function  printAll()
	{

	}

	public function arrow_down($color = "#000") {
		return <<<xml
<svg viewBox="0 0 24 24" height="14px" width="14px"><polyline fill="none" points="21,8.5 12,17.5 3,8.5 " stroke="$color" stroke-miterlimit="10" stroke-width="2"/></svg>
xml;
	}
	public function home() {
		return <<<xml
<svg viewBox="0 0 16 16" width="24" height="24">
	<g>
		<path d="M16,8 L14,8 L14,16 L10,16 L10,10 L6,10 L6,16 L2,16 L2,8 L0,8 L8,0 L16,8 Z M16,8"/>
	</g>
</svg>
xml;
	}
	public function trend($color = "#000") {
		return <<<xml
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="$color" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
xml;
	}
	public function globe($color = "#000") {
		return <<<xml
<svg viewBox="0 0 512 512" width="24" height="24" fill="$color">
	<g>
		<path
   d="M 256,0 C 114.842,0 0,114.842 0,256 0,397.158 114.842,512 256,512 397.158,512 512,397.158 512,256 512,114.842 397.158,0 256,0 Z m -83.233,49.548 c -15.431,21.032 -26.894,45.924 -35.095,70.354 -14.907,-5.344 -28.707,-11.736 -41.104,-19.09 21.407,-21.985 47.304,-39.572 76.199,-51.264 z m -97.873,77.154 c 15.971,9.964 34.036,18.452 53.65,25.317 -6.467,27.334 -10.344,56.811 -11.382,87.284 H 34.016 c 3.112,-41.778 17.808,-80.38 40.878,-112.601 z M 74.893,385.297 C 51.824,353.078 37.127,314.475 34.015,272.696 h 83.145 c 1.038,30.474 4.915,59.95 11.382,87.284 -19.613,6.865 -37.676,15.353 -53.649,25.317 z m 21.676,25.89 c 12.397,-7.354 26.197,-13.746 41.104,-19.09 8.2,24.428 19.663,49.32 35.095,70.354 -28.896,-11.691 -54.793,-29.278 -76.199,-51.264 z m 142.735,64.339 c -34.478,-12.654 -57.72,-57.982 -69.619,-92.899 21.841,-5.198 45.296,-8.391 69.619,-9.4 z m 0,-135.713 c -27.403,1.061 -53.935,4.708 -78.711,10.722 -5.624,-24.321 -9.038,-50.587 -10.029,-77.84 h 88.74 z m 0,-100.509 h -88.74 c 0.99,-27.253 4.404,-53.518 10.029,-77.84 24.776,6.014 51.308,9.661 78.711,10.722 z m 0,-100.531 c -24.322,-1.008 -47.777,-4.203 -69.619,-9.4 11.89,-34.894 35.131,-80.242 69.619,-92.899 z m 197.803,-12.07 c 23.069,32.219 37.766,70.822 40.878,112.601 H 394.84 c -1.038,-30.474 -4.915,-59.95 -11.382,-87.284 19.613,-6.865 37.676,-15.353 53.649,-25.317 z m -21.676,-25.89 c -12.397,7.354 -26.197,13.746 -41.104,19.09 -8.2,-24.428 -19.663,-49.32 -35.095,-70.354 28.896,11.691 54.793,29.278 76.199,51.264 z M 272.696,36.474 c 34.478,12.654 57.72,57.982 69.619,92.899 -21.841,5.198 -45.296,8.391 -69.619,9.4 z m 0,135.713 c 27.403,-1.061 53.935,-4.708 78.711,-10.722 5.624,24.321 9.038,50.587 10.029,77.84 h -88.74 z m 0,100.397 h 88.74 c -0.99,27.253 -4.404,53.63 -10.029,77.951 -24.776,-6.014 -51.308,-9.661 -78.711,-10.722 z m 0,202.942 V 373.227 c 24.322,1.008 47.777,4.203 69.619,9.4 -11.89,34.893 -35.132,80.241 -69.619,92.899 z m 66.537,-13.074 c 15.431,-21.032 26.894,-45.924 35.095,-70.354 14.907,5.344 28.706,11.736 41.104,19.09 -21.407,21.985 -47.304,39.572 -76.199,51.264 z m 97.873,-77.154 c -15.971,-9.964 -34.036,-18.452 -53.65,-25.317 6.467,-27.334 10.344,-56.922 11.382,-87.395 h 83.145 c -3.111,41.778 -17.807,80.491 -40.877,112.712 z"/>
	</g>
</svg>
xml;
	}
	public function expand($color = "#000") {
		return <<<xml
<svg viewBox="0 0 486.538 486.538" height="40" width="40" fill="$color">
	<g
	     transform="translate(-291.115,291.11499)">
			<polygon points="458.385,195.423 458.385,175.731 324.731,175.727 486.538,13.923 472.615,0 310.808,161.803 310.808,28.154 291.115,28.154 291.115,195.418 "/>
	</g>
	<g transform="translate(291.11499,291.11499)">
		<polygon points="28.163,175.731 28.163,195.423 195.423,195.418 195.423,28.154 175.731,28.154 175.731,161.803 13.923,0 0,13.923 161.808,175.727 "/>
	</g>
	<g transform="translate(-291.115,-291.115)">
		<polygon points="310.808,324.735 472.615,486.538 486.538,472.615 324.731,310.812 458.385,310.808 458.385,291.115 291.115,291.12 291.115,458.385 310.808,458.385 "/>
	</g>
	<g transform="translate(291.11499,-291.115)">
		<polygon
	   points="195.423,458.385 195.423,291.12 28.163,291.115 28.163,310.808 161.808,310.812 0,472.615 13.923,486.538 175.731,324.735 175.731,458.385 "/>
	</g>
</svg>
xml;
	}
	public function shrink($color = "#000") {
		return <<<xml
<svg viewBox="0 0 486.538 486.538" width="40" height="40" fill="$color">
	<g>
		<polygon points="486.538,13.923 472.615,0 310.808,161.803 310.808,28.154 291.115,28.154 291.115,195.418 458.385,195.423 458.385,175.731 324.731,175.727"/>
	</g>
	<g>
		<polygon points="175.731,28.154 175.731,161.803 13.923,0 0,13.923 161.808,175.727 28.163,175.731 28.163,195.423 195.423,195.418 195.423,28.154"/>
	</g>
	<g>
		<polygon points="324.731,310.812 458.385,310.808 458.385,291.115 291.115,291.12 291.115,458.385 310.808,458.385 310.808,324.735 472.615,486.538 486.538,472.615"/>
	</g>
	<g>
		<polygon points="28.163,291.115 28.163,310.808 161.808,310.812 0,472.615 13.923,486.538 175.731,324.735 175.731,458.385 195.423,458.385 195.423,291.12"/>
	</g>
</svg>
xml;
	}

	public function gear($color = "#000") {
		return <<<xml
<svg width="40" height="40" viewBox="0 0 363.90799 363.90799" fill="$color"
	<g>
	    <path d="m 363.908,212.28 v -60.654 h -49.13 c -3.463,-15.158 -9.507,-29.286 -17.534,-42.05 l 34.83,-34.828001 -42.914,-42.881 -34.812,34.795 c -12.778,-8.025 -26.906,-14.066 -42.066,-17.529 V 0 h -60.654 v 49.132999 c -15.163,3.463 -29.288,9.504 -42.069,17.558 l -34.828002,-34.824 -42.881001,42.881 34.829001,34.828001 c -8.039,12.764 -14.083,26.892 -17.548,42.05 H 0 v 60.654 h 49.129998 c 3.465,15.163 9.493,29.29 17.534,42.055 L 31.849997,289.16 74.735998,332.074 109.559,297.244 c 12.781,8.027 26.906,14.071 42.069,17.534 v 49.13 h 60.654 v -49.13 c 15.161,-3.463 29.271,-9.507 42.053,-17.534 l 34.825,34.83 42.914,-42.914 -34.83,-34.825 c 8.027,-12.797 14.071,-26.892 17.534,-42.055 z m -181.953,45.49 c -41.875,0 -75.816,-33.943 -75.816,-75.816 0,-41.878 33.941,-75.812 75.816,-75.812 41.875,0 75.814,33.934 75.814,75.812 10e-4,41.872 -33.938,75.816 -75.814,75.816 z"/>
	</g>
</svg>
xml;
	}
	public function edit($color = "#000") {
		return <<<xml
<svg height="16" width="16" viewBox="0 0 600 600">
  <g stroke="$color" fill="none">
   <path d="m70.064 422.35 374.27-374.26 107.58 107.58-374.26 374.27-129.56 21.97z" stroke-width="30"/>
   <path d="m70.569 417.81 110.61 110.61" stroke-width="25"/>
   <path d="m491.47 108.37-366.69 366.68" stroke-width="25"/>
   <path d="m54.222 507.26 40.975 39.546" stroke-width="25"/>
  </g>
</svg>
xml;
	}
	public function garbage($color = "#000")
	{
		return <<<xml
<svg viewBox="0 0 433 433" height="14" width="14">
	<path d="M371.5,38h-98.384V0H159.884v38H61.5v90h20v305h270V128h20V38z M189.884,30h53.231v8h-53.231V30z M91.5,68h250v30h-250V68z
	 M241.5,128v275h-50V128H241.5z M111.5,128h50v275h-50V128z M321.5,403h-50V128h50V403z"/>
</svg>
xml;
	}
	public function heart()
	{
		return <<<xml
<svg viewBox="0 0 48 48" height="48" width="48" fill="#fff0" stroke-width="3" stroke="#fff">
	<path  d="M 23.924948,9.0032158 C 32.227971,0.70019061 43.638272,8.3531236 43.563217,16.227494 C 43.494602,23.426038 38.008283,26.873511 24.225169,39.677567 C 9.7983996,27.766131 4.7153311,25.019309 4.7903867,16.478476 C 4.8654422,7.6374205 14.633621,1.0021667 23.924948,9.0032158 z"/>
</svg>
xml;
	}

	public function grid()
	{
		return <<<xml
<svg viewbox="0 0 24 24" height="24" width="24">
	<g>
		<rect x="9" y="9" width="6" height="6"/>
		<rect x="0" y="0" width="6" height="6"/>
		<rect x="9" y="18" width="6" height="6"/>
		<rect x="0" y="9" width="6" height="6"/>
		<rect x="0" y="18" width="6" height="6"/>
		<rect x="18" y="0" width="6" height="6"/>
		<rect x="9" y="0" width="6" height="6"/>
		<rect x="18" y="9" width="6" height="6"/>
		<rect x="18" y="18" width="6" height="6"/>
	</g>
</svg>
xml;
	}

	public function grid2x2()
	{
		return <<<xml
<svg viewbox="0 0 24 24" height="24" width="24">
	<g>
		<rect x="0" y="0" width="10" height="10"/>
		<rect x="12" y="0" width="10" height="10"/>
		<rect x="12" y="12" width="10" height="10"/>
		<rect x="0" y="12" width="10" height="10"/>
	</g>
</svg>
xml;
	}

	public function hamburger()
	{
		return <<<xml
<svg width="24" height="24" viewBox="0 0 24 24">
	<path d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/>
</svg>
xml;
	}

	public function list()
	{
		return <<<xml
<svg xwidth="24" height="24" viewBox="0 0 24 24">
	<rect x="0" y="0" width="6" height="6"/>
	<rect x="8" y="0" width="16" height="6"/>
	<rect x="0" y="9" width="6" height="6"/>
	<rect x="8" y="9" width="16" height="6"/>
	<rect x="0" y="18" width="6" height="6"/>
	<rect x="8" y="18" width="16" height="6"/>
</svg>
xml;
	}

	public function folder()
	{
		return <<<xml
<svg height="24" width="24">
	<path d="M0 0 L8 0 L8 2 L24 2 L24 24 L0 24 Z" />
</svg>
xml;
	}

	public function person()
	{
		return <<<xml
<svg height="24" width="24">
	<rect x="6" y="0" width="12" height="12"/>
  <rect x="0" y="14" width="24" height="14"/>
</svg>
xml;
	}
}

