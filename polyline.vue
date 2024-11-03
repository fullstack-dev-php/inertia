<script setup lang="ts">
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import L from 'leaflet';
import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer, LPolyline, LTooltip } from "@vue-leaflet/vue-leaflet";
import { ref } from 'vue';

// Tọa độ trung tâm của bản đồ
const center = ref([45.584262164368, 148.7780000003]);

// Giới hạn bản đồ
const bounds = L.latLngBounds([[-85, -180], [85, 180]]);

// URL của Tile Layer cho Google Maps
const url = 'https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}';
const subdomains = ['mt0', 'mt1', 'mt2', 'mt3'];

// Nhận dữ liệu `depth` từ props
const props = defineProps({
  depth: Object
});
</script>

<template>
  <DefaultLayout>
    <div class="rounded w-100" style="height: calc(100vh - 140px);">
      <l-map
        :zoom="11"
        :center="center"
        :min-zoom="2"
        :max-bounds="bounds"
        world-copy-jump
      >
        <l-tile-layer
          :url="url"
          :max-zoom="21"
          :subdomains="subdomains">
        </l-tile-layer>

        <!-- Vẽ LineString bằng LPolyline -->
         <template v-for="de in props.depth" :key="de.id">
          <div>         
            <l-polyline
            :lat-lngs="de.geometry.coordinates"
            :color="'#' + ((1<<24)*Math.random() | 0).toString(16)"
            :weight="4"
          >
            <!-- <tooltip :content="'ID: ' + de.id" sticky /> -->
            <l-tooltip :content="'ID: ' + de.id" permanent />
          </l-polyline>
          </div>
         </template>
      </l-map>
    </div>
  </DefaultLayout>
</template>

<style>
.leaflet-top, .leaflet-bottom {
    display: none !important;
}
</style>

$coordinates = [
            [148.7780000003, 45.584262164368],
            [148.7799999999, 45.584701447214],
            [148.7820000004, 45.585114713573],
            [148.784, 45.58529470029]
        ];
        $points = array_map(fn($coordinate) => new Point($coordinate[0], $coordinate[1]), $coordinates);
        $lineString = new LineString($points);
        Voyage::create([
            'user_id' => 5,
            'name' => 'Sample Route',
            'route' => $lineString,
            'route_length' => 5.2,
            'start_time' => Carbon::parse('2024-11-01 08:00:00'),
            'end_time' => Carbon::parse('2024-11-01 10:00:00'),
        ]);
        $voyages = Voyage::all();
        return response()->json($voyages, 200);
