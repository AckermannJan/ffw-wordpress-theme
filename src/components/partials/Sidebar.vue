<template>
    <div>
        <div class="sideBarEntry mb-3" v-if="!isLoading">
            <div class="headline font-weight-bold">Letzter Einsatz</div>
            <div class="sideBarEntry__body">{{ latestAlarm.post_title }}</div>
        </div>
        <div class="calendar" v-if="!isLoading">
            <div class="headline font-weight-bold">Termine</div>
            <div class="calendar__body">
                <v-row class="calendar__entry mb-3" v-for="meeting in nextThreeMeetings">
                    <v-col class="calendar__date">
                        <span>SA</span>
                        <span>19</span>
                    </v-col>
                    <v-col class="calender__info" style="padding: 0; position: relative">
                        <div>{{ meeting.post_title }}</div>
                        <div class="subtitle-2 calendar__detail-date">{{ meeting.date.timestamp | date }}</div>
                    </v-col>
                </v-row>
                <a class="link">Mehr anzeigen...</a>
            </div>
        </div>
        <div class="sideBarEntry mb-3" v-if="!isLoading">
            <div class="headline font-weight-bold">Infos für Bürger</div>
            <div class="sideBarEntry__body sideBarEntry__body--noBg sideBarEntry__body--noPadding" />
        </div>
        <div class="sideBarEntry mb-3" v-if="!isLoading">
            <div class="headline font-weight-bold">Partner der Feuerwehr</div>
            <div class="sideBarEntry__body sideBarEntry__body--noBg">
                <img src="http://www.stepstone.de/upload_de/logo/D/logoDATRON_AG_60143DE.gif" />
            </div>
        </div>
    </div>
</template>

<script>
  import {mapGetters} from "vuex";
  import moment from 'moment'

  export default {
    name: "Sidebar",
    filters: {
      date (date) {
        moment.locale('de');
        return moment(parseInt(date)).format('DD MMMM') + ' um ' + moment(parseInt(date)).format('HH:MM')
      }
    },
    computed: {
      ...mapGetters('sideBar', {
        isLoading: 'isLoading',
        latestAlarm: 'latestAlarm',
        nextThreeMeetings: 'nextThreeMeetings',
      }),
    },
  }
</script>

<style scoped lang="scss">
   @import "Sidebar";
</style>