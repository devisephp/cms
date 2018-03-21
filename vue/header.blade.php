<hero></hero>
<h1 @click="customAlerts">@{{ page.title }}</h1>
<p>today: {{ date('Y-m-d') }}</p>

<devise-scripts>
export module {
  methods: {
    customAlerts () {
      alert('here')
    }
  }
}
</devise-scripts>
