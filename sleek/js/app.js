document.addEventListener('livewire:init', () => {
  Livewire.hook('request', ({ fail }) => {
    fail(({ status, preventDefault }) => {
      if (status === 419) {
        window.location.reload()

        preventDefault()
      }
    })
  })
})

let currentBreakpoint = window.innerWidth < 768 ? 'mobile' : 'desktop'

window.addEventListener('resize', () => {
  const newBreakpoint = window.innerWidth < 768 ? 'mobile' : 'desktop'

  if (newBreakpoint !== currentBreakpoint) {
    currentBreakpoint = newBreakpoint

    document.querySelectorAll('[x-data]').forEach(el => {
      if (el.__x) {
        el.__x.$nextTick(() => {
          el.__x.updateElements(el)
        })
      }
    })

    window.dispatchEvent(
      new CustomEvent('breakpoint-changed', {
        detail: { breakpoint: currentBreakpoint },
      })
    )
  }
})
Alpine.store('notifications', {
  init() {
    Livewire.on('notify', e => {
      Alpine.store('notifications').addNotification(e)
    })
  },
  notifications: [],
  addNotification(notification) {
    notification = notification[0]
    notification.show = false
    notification.id = Date.now() + Math.floor(Math.random() * 1000)
    this.notifications.push(notification)

    Alpine.nextTick(() => {
      this.notifications = this.notifications.map(notif => {
        if (notif.id === notification.id) {
          notif.show = true
        }
        return notif
      })
    })

    setTimeout(() => {
      this.removeNotification(notification.id)
    }, notification.timeout || 5000)
  },
  removeNotification(id) {
    this.notifications = this.notifications
      .map(notification => {
        if (notification.id === id) {
          notification.show = false
        }
        return notification
      })
      .filter(notification => notification.show)
  },
})
