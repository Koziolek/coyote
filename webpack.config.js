var webpack = require('webpack');
var path = require('path');

module.exports = {
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
                query: {
                    presets: ['es2015']
                }
            }
        ]
    },
    output: {
        filename: '[name].js',
        chunkFilename: '[chunkhash].js',
        publicPath: '/js/'
    },
    context: path.join(__dirname, 'resources/assets/js'),
    entry: {
        app: './app.js',
        posting: './posting.js',
        microblog: './pages/microblog.js',
        forum: './pages/forum.js',
        wiki: './pages/wiki.js',
        job: './pages/job.js',
        homepage: './pages/homepage.js',
        pm: './pages/pm.js',
        profile: './pages/profile.js',
        'job-submit': './pages/job/submit.js',
    },
    plugins: [
        new webpack.optimize.CommonsChunkPlugin({name: "app", minChunks: 2, chunks: ['microblog', 'pm', 'forum', 'wiki', 'job', 'homepage', 'job-submit']}),
    ]
};

if (process.env.NODE_ENV === 'production') {
    //
} else {
    module.exports.devtool = '#source-map';
}
