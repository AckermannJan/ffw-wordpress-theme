import axios from 'axios';
import SETTINGS from '../settings';

export default {
  getCategories(cb) {
    axios
      .get(
        SETTINGS.API_BASE_PATH +
        'categories?sort=name&hide_empty=true&per_page=50'
      )
      .then(response => {
        cb(response.data.filter(c => c.name !== 'Uncategorized'));
      })
      .catch(e => {
        cb(e);
      });
  },

  getPages(cb) {
    axios
      .get(SETTINGS.API_BASE_PATH + 'pages?per_page=10')
      .then(response => {
        cb(response.data);
      })
      .catch(e => {
        cb(e);
      });
  },

  getPage(id, cb) {
    if(!Number.isInteger(id) || !id)
      return false;

    axios
      .get(SETTINGS.API_BASE_PATH + 'pages/' + id)
      .then(response => {
        cb(response.data);
      })
      .catch(e => {
        cb(e);
      });
  },

  getPosts(limit = 5, cb) {
    axios
      .get(SETTINGS.API_BASE_PATH + 'posts?per_page=' + limit)
      .then(response => {
        cb(response.data);
      })
      .catch(e => {
        cb(e);
      });
  },

  getPost(id, cb) {
    axios
      .get(SETTINGS.API_BASE_PATH + 'posts/' + id)
      .then(response => {
        cb(response.data);
      })
      .catch(e => {
        cb(e);
      });
  },

  getAlarm(id, cb) {
    axios.get(SETTINGS.CUSTOM_API_BASE_PATH + 'getAlarmPost/', {
      params: {
        id
      }
    })
        .then(response => {
        cb(response.data);
      })
      .catch(e => {
        cb(e);
      });
  },

  getIndexInfo(cb) {
    axios.get(SETTINGS.CUSTOM_API_BASE_PATH + 'getIndexInfo/')
      .then(response => {
        cb(response.data);
      })
      .catch(e => {
        cb(e);
      });
  },

  getSidebarInfo(cb) {
    axios.get(SETTINGS.CUSTOM_API_BASE_PATH + 'getSidebarInfo/')
      .then(response => {
        cb(response.data);
      })
      .catch(e => {
        cb(e);
      });
  },

  getAllAlarmsFromYear(year, cb) {
    axios.get(SETTINGS.CUSTOM_API_BASE_PATH + 'getAllAlarmsFromYear/', {
      params: {
        year
      }
    })
      .then(response => {
        cb(response.data);
      })
      .catch(e => {
        cb(e);
      });
  },

  getAllMeetings(cb) {
    axios.get(SETTINGS.CUSTOM_API_BASE_PATH + 'getAllMeetings/')
      .then(response => {
        cb(response.data);
      })
      .catch(e => {
        cb(e);
      });
  },

};
