/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue'
import Nova from './Nova'
import './plugins'
/**
 * Next, we'll setup some of Nova's Vue components that need to be global
 * so that they are always available. Then, we will be ready to create
 * the actual Vue instance and start up this JavaScript application.
 */
import './fields'
import './components'

Vue.config.productionTip = false

Vue.mixin(require('./base'))

(function () {
  this.CreateNova = function (config) {
    return new Nova(config)
  }
}.call(window))
