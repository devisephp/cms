import Vue from 'vue'
import { TweenMax, CSSPlugin } from 'gsap'
const plugins = [CSSPlugin]; 

export default {
  bind: function (panel, binding, vnode) {
    let panelContents = panel.querySelector('.dvs-panel-contents')
    let panelShine = panel.querySelector('.dvs-panel-shine')

    let xEffectStrength = 5
    let rotationXLimit = 8
    let yEffectStrength = 5
    
    function focusPanel(scale, opacity, duration) {
      TweenMax.to(panelContents, duration, {
        scale: scale,
        opacity: opacity,
        rotationX: '0deg',
        rotationY: '0deg',
        ease: 'elastic'
      })
    }

    function setPanelShine(xStrength, yStrength) {
      TweenMax.to(panelShine, 0.5, {
        top: `${xStrength * panelContents.offsetWidth}px`,
        left: `${yStrength * panelContents.offsetHeight}px`,
        ease: 'elastic'
      })
    }

    function tiltPanel(el, event) {

      if (panelContents.offsetWidth < 500) {
        let x = event.clientX - el.offsetLeft
        let y = event.clientY - el.offsetTop

        let xStrength = getXStrength(y) 
        let yStrength = getYStrength(x)

        setPanelShine(xStrength, yStrength)

        var rotationX = xStrength * xEffectStrength
        if (rotationX > rotationXLimit) {
          rotationX = rotationXLimit
        }

        TweenMax.to(panelContents, 0.5, {
          rotationX: `${rotationX}deg`,
          rotationY: `${yStrength * yEffectStrength * -1}deg`,
          perspective: '1000px',
          ease: 'elastic'
        })
      } else {
        focusPanel(1, 1, 0.2)
      }
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
    focusPanel(0.95, 1, 0)

    function enterPanel() { focusPanel(1.0, 1, 0.2) };
    function moveOverPanel(event) { tiltPanel(this, event) };
    function leavePanel() { focusPanel(0.95, 1, 0.4) };

    panel.addEventListener('mouseenter', enterPanel, false);
    panel.addEventListener('mousemove', moveOverPanel, false);
    panel.addEventListener('mouseleave', leavePanel, false);
  }
}
