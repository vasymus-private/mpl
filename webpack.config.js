const path = require('path')

// https://stefanbauer.me/tips-and-tricks/autocompletion-for-webpack-path-aliases-in-phpstorm-when-using-laravel-mix
module.exports = {
    output: {chunkFilename: 'js/[name].js?id=[chunkhash]'},
    resolve: {
        alias: {
            '@': path.resolve('./resources/js/'),
            ziggy: path.resolve('./vendor/tightenco/ziggy/dist/vue'),
        },
        extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx'],
    },
    devServer: {
        allowedHosts: 'all',
    },
    module  : {
        rules : [
            {
                test    : /\.tsx?$/,
                loader  : 'ts-loader',
                options : {appendTsSuffixTo : [/\.vue$/]},
                exclude : /node_modules/,
            },
        ],
    },
    // stats: {
    //     children: true,
    // }
}
