

export default {
  methods: {
    formatDate (dateObj) {
      var month = ('0' + (dateObj.getMonth()+1)).slice(-2) //months from 1-12
      var day = ('0' + dateObj.getDate()).slice(-2)
      var year = dateObj.getUTCFullYear()

      console.log(day)

      return `${year}-${month}-${day}`
    }
  }
}
