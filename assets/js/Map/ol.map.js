let MapOl = ol.Map
let View = ol.View
let OverviewMap = ol.control.OverviewMap
let ScaleLine = ol.control.ScaleLine
let ZoomSlider = ol.control.ZoomSlider
let {
	defaults: defaultControls
} = ol.control.defaults
let TileLayer = ol.layer.Tile
let OSM = ol.source.OSM
let VectorSource = ol.source.Vector
let VectorLayer = ol.layer.Vector

// Configuration Constants
const GEOCODE_MIN_DELAY = 5000; // 5 seconds between geocoding requests
const MAX_MARKERS = 10; // Maximum markers to show
const DEFAULT_ZOOM = 18;
// const DEFAULT_CENTER = [110.4218, -7.07300]; // Initial map center [lon, lat]-7.073223409384761, 110.4215172436207
const DEFAULT_CENTER = [110.4215172436207, -7.073223409384761]; // Initial map center [lon, lat]-7.073223409384761, 110.4215172436207

let nilaiZoom = DEFAULT_ZOOM;

let straitSource = new VectorSource({
	features: [],
	wrapX: true
})
let straitsLayer = new VectorLayer({
	source: straitSource
})

let OverviewMapControl = new OverviewMap({
	className: 'ol-overviewmap ol-custom-overviewmap',
	layers: [
		new TileLayer({
			source: new OSM()
		})
	],
	collapseLabel: '\u00BB',
	label: '\u00AB',
	collapsed: false
})

let map = new MapOl({
	controls: defaultControls().extend([
		OverviewMapControl,
		new ScaleLine(),
		new ZoomSlider()
	]),
	nilaiZoom,
	layers: [
		new TileLayer({
			source: new OSM()
		}),
		straitsLayer
	],
	target: 'map',
	view: new View({
		center: ol.proj.fromLonLat([110.4218, -7.07300]),
		maxZoom: 20,
		minZoom: 11,
		zoom: 18
	})
})

// Popup Initialization
const initPopup = (id, duration) => {
	const container = document.getElementById(id);
	return new ol.Overlay({
		element: container,
		autoPan: true,
		autoPanAnimation: {
			duration: duration
		}
	});
};

const popup = initPopup('popup');
const popupClick = initPopup('popupClick');
map.addOverlay(popup, 450);
map.addOverlay(popupClick, 250);

function AnimatePoint(feature, distance = 100, speed = 0.5) {
	var c = feature.getGeometry().getCoordinates();
	var start = c[1];
	var end = start + (distance / nilaiZoom);
	var curr = start;
	var up = true;

	let intervalId = window.setInterval(() => {
		if (up) {
			curr += speed;
			if (curr > end) {
				up = false;
			}
		} else {
			curr -= speed;
			if (curr < start) {
				up = true;
			}
		}
		var pos = [c[0], curr];
		feature.getGeometry().setCoordinates(pos);
	}, 35);

	// Hentikan interval jika tidak lagi diperlukan
	return () => clearInterval(intervalId);
}

function createMarkerStyle() {
	return new ol.style.Style({
		image: new ol.style.Icon({
			src: 'assets/icon-svg/icon-location-pin.svg',
			scale: 0.8,
			anchor: [0.5, 1],
			anchorXUnits: 'fraction',
			anchorYUnits: 'fraction'
		})
	});
}

function clearMarkers() {
	straitSource.removeFeature(lastMarker)
	$('#latitude').val('');
	$('#longitude').val('');
}

// Event Listeners
map.on('pointermove', function (evt) {
	const feature = map.forEachFeatureAtPixel(evt.pixel, feat => feat);

	if (feature) {
		const position = ol.proj.transform(
			[feature.get('lon'), feature.get('lat')],
			'EPSG:4326',
			'EPSG:3857'
		);
		document.getElementById('popup-content').innerHTML = feature.get('desc');
		MarkerOnTop(feature, true);
		popup.setPosition(position);
	} else {
		straitSource.getFeatures().forEach(f => MarkerOnTop(f, false));
		popup.setPosition(undefined);
	}
});

map.on('click', function (evt) {
	const feature = map.forEachFeatureAtPixel(evt.pixel, feat => feat);

	if (feature) {
		const position = ol.proj.transform(
			[feature.get('lon'), feature.get('lat')],
			'EPSG:4326',
			'EPSG:3857'
		);
		document.getElementById('popup-content-click').innerHTML = feature.get('desc');
		MarkerOnTop(feature, true);
		popupClick.setPosition(position);
	} else {
		popupClick.setPosition(undefined);
	}
});

nilaiZoom = map.getView().getZoom();
map.on('moveend', function (e) {
	const newZoom = map.getView().getZoom();
	if (nilaiZoom !== newZoom) {
		nilaiZoom = newZoom;
	}
});

// Helper Functions
function MarkerOnTop(feature, show = false) {
	const style = feature.getStyle();
	style.zIndex = show ? 9999 : 999;
	style.zIndex_ = show ? 9999 : 999;
	feature.setStyle(style);
}
