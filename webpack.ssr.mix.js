const mix = require('laravel-mix')
const webpackConfig = require('./webpack.config')
const webpackNodeExternals = require('webpack-node-externals')


mix
    .options({ manifest: false })
    .js('resources/js/admin/inertia/ssr.js', 'public/_admin/js')
    .vue({
        // runtimeOnly: (process.env.NODE_ENV || 'production') === 'production',
        version: 3,
        options: { optimizeSSR: true }
    })
    .webpackConfig(webpackConfig)
    .webpackConfig({
        target: 'node',
        externals: [webpackNodeExternals()],
    })
