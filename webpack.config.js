const webpack = require('webpack');
const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');

module.exports = {
    mode: 'production',
    entry: {
        app: './src/app.js',
        footer: './src/footer.js'
    },

    output: {
        path: path.resolve(__dirname, 'public/dist'),
        filename: 'js/[name].js'
    },

    watchOptions: {
        ignored: [
            'app',
            'public/**', 
            'node_modules/**',
            'admin/**',
            'contributing/**',
            'system/**',
            'test/**',
            'user_guide_src/**',
            'writable/**',
            '.editconfig',
            '.gitignore',
            '.gitattibute',
            '.nokekyll',
            '.travis.yml',
            'CHANGELOG.md',
            'CODE_OF_CONDUCT.md',
            'composer.json',
            'composer.lock',
            'CONTRIBUTING.md',
            'DCO.txt',
            'env',
            'lisense.txt',
            'package.json',
            'package-lock.json',
            'phpdoc.dist.xml',
            'PULL_REQUEST_TEMPLATE.md',
            'README.md',
            'spark',
            'stale.yml',
            'Vagrantfile.dist',
            'webpack.config.js'
        ]
    },

    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },

            {
                test: /\.css$/i,
                use: [MiniCssExtractPlugin.loader, 'css-loader'],
            },

            {
                test: /\.s[ac]ss$/i,
                use: [
                    {
                        'loader': MiniCssExtractPlugin.loader
                    },
                    'css-loader',
                    'sass-loader',
                ],
            },
            {
                test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: '/css/fonts/',
                            publicPath: '/dist/css/fonts/'
                        }
                    }
                ]
            }
        ]
    },

    plugins: [
        new CleanWebpackPlugin(),
        
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
            chunkFilename: 'css/[id].css',
        }),

        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        }),

        new webpack.ProvidePlugin({
            Plyr: 'Plyr'
        }),

        new webpack.ProvidePlugin({
            AOS: 'AOS'
        }),

        new webpack.ProvidePlugin({
            stretchTextarea: 'stretchTextarea'
        })
    ],

    //Minimize Css.
    optimization: {
        minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
    }
};