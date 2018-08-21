import Vue from 'vue'
import { TweenMax, CSSPlugin } from 'gsap'
const plugins = [CSSPlugin]; 

export default {
  bind: function (panel, binding, vnode) {

    let panelContents = panel.querySelector('.dvs-panel-contents')
    let panelZoom1 = panel.querySelector('.dvs-panel-zoom1')
    let panelShine = panel.querySelector('.dvs-panel-shine')
    let xEffectStrength = 30
    let yEffectStrength = 15
    
    function focusPanel(scale, opacity, duration) {
      TweenMax.to(panelContents, duration, {
        scale: scale,
        opacity: opacity,
        rotationX: '0deg',
        rotationY: '0deg',
        ease: 'elastic'
      })

      if (panelZoom1) {
        TweenMax.to(panelZoom1, duration, {
          z: 5,
          ease: 'elastic'
        })
      }
    }

    function setPanelShine(xStrength, yStrength) {
      TweenMax.to(panelShine, 0.5, {
        top: `${xStrength * panelContents.offsetWidth}px`,
        left: `${yStrength * panelContents.offsetHeight}px`,
        ease: 'elastic'
      })
    }

    function tiltPanel(el, event) {

      let x = event.clientX - el.offsetLeft
      let y = event.clientY - el.offsetTop

      let xStrength = getXStrength(y) 
      let yStrength = getYStrength(x)

      setPanelShine(xStrength, yStrength)

      TweenMax.to(panelContents, 0.5, {
        rotationX: `${xStrength * xEffectStrength}deg`,
        rotationY: `${yStrength * yEffectStrength * -1}deg`,
        perspective: '1000px',
        ease: 'elastic'
      })
    }

    function getYStrength (cx) {
      let panelWidth = panel.offsetWidth
      let distanceFromMiddle = cx - (panelWidth/2)
      return distanceFromMiddle / (panelWidth/2)
    }

    function getXStrength (cy) {
      let panelHeight = panel.offsetHeight
      let distanceFromMiddle = cy - (panelHeight/2)
      return distanceFromMiddle / panelHeight
    }

    setPanelShine()

    // Set the initial position of the panel
    focusPanel(0.9, 0.85, 0)

    function enterPanel() { focusPanel(1.0, 1, 0.2) };
    function moveOverPanel(event) { tiltPanel(this, event) };
    function leavePanel() { focusPanel(0.9, 0.7, 0.4) };

    panel.addEventListener('mouseenter', enterPanel, false);
    panel.addEventListener('mousemove', moveOverPanel, false);
    panel.addEventListener('mouseleave', leavePanel, false);
  }
}
