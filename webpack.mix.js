require('dotenv').config()
const mix = require('laravel-mix');
require('vuetifyjs-mix-extension')
const path=require('path')
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')
//const webpackVuetify= require('./webpack-config')
const CompressionPlugin = require('compression-webpack-plugin');
const zlib = require('zlib');
require('laravel-mix-clean-css');
require('laravel-mix-bundle-analyzer');
require('laravel-mix-splitjs');
require('laravel-mix-purgecss')
const FontminPlugin = require('fontmin-webpack')
require('laravel-mix-alias')
//fs = require('fs')
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
let fs = require('fs');
const webpack = require('webpack');

Mix.manifest.name = 'mix-manifest-new.json';

// end of the file
mix.webpackConfig({

    plugins: [
        new webpack.ContextReplacementPlugin(
            /moment[\/\\]locale/,
            // A regular expression matching files that should be included
            /(en-gb)\.js/
        )
    ]
});
if (process.env.COMP_TYPE === 'css') {
    mix
        .sass('resources/sass/app.scss', 'public/dist/css').version()
        // .purgeCss({
        //     enabled: !mix.inProduction(),
        //     content: [
        //         './resources/views/**/*.blade.php',
        //         './resources/js/**/*.js',
        //     ]
        // })
        .sass('resources/sass/external_resources~2.scss', 'public/dist/css').version()
        .styles('resources/sass/all.css', 'public/dist/css/all.css').version()
        .options({
            extractVueStyles: 'public/dist/css/vue-components.css',
            purfifyCss:true,
            cleanCss: {
                level: {
                    1: {
                        specialComments: 'none'
                    }
                }
            },
        })
        // .cleanCss({
        //     level: 2,
        //     format: mix.inProduction() ? false : 'beautify' // Beautify only in dev mode
        // })
        .sourceMaps()

    mix.then(function () {
        let content = fs.readFileSync('./public/mix-manifest-new.json', 'utf8');
        content = content.replace(/[{}]+/g, '')
        content = content + ','
        content = content.replace(/(\r\n|\n|\r)/gm, "")
        let data = fs.readFileSync('./public/mix-manifest.json').toString().split("\n")
        let deleteCount=0;
        if (!mix.inProduction()) {
            deleteCount=1;
        }
        data.splice(2, deleteCount, content)
        let text = data.join("\n")
        fs.writeFile('./public/mix-manifest.json', text, function (err) {
            if (err) return console.log(err);
        });
        fs.unlinkSync('./public/mix-manifest-new.json');
    })
} else {


     mix.extend('vuetify', new class {
         webpackConfig (config) {
             config.plugins.push(new VuetifyLoaderPlugin({
                 progressiveImages: {
                     resourceQuery: /lazy\?vuetify-preload/
                 }
             }))
         }
     })
     mix.vuetify()
    mix.then(function () {
        fs.renameSync('./public/mix-manifest-new.json', './public/mix-manifest.json')
        if (!mix.inProduction()) {
            let content = '"/dist/css/app.css": "/dist/css/app.css", "/dist/css/external_resources~2.css":"/dist/css/external_resources~2.css","/dist/css/all.css": "/dist/css/all.css",'
            let data = fs.readFileSync('./public/mix-manifest.json').toString().split("\n")
            data.splice(2, 0,content)
            let text = data.join("\n")
            fs.writeFile('./public/mix-manifest.json', text, function (err) {
                if (err) return console.log(err);
            });
        }
    })
    if (mix.inProduction()) {
        mix
            .webpackConfig(webpack => {
                return {
                    output: {
                        chunkFilename: '[name].js?id=[chunkhash]',
                        publicPath: '/'
                    },
                };
            }).version()
    } else {
        mix
            .webpackConfig(webpack => {
                return {
                    output: {
                        chunkFilename: '[name].js',
                        publicPath: '/'
                    },
                };
            })
    }
    mix.setPublicPath('./public');
    mix
        .webpackConfig({
            resolve: {
                alias: {
                    '~': path.resolve(__dirname, 'resources/js/'),
                    '@': path.resolve('resources/'),
                    '@sass': path.resolve('resources/sass'),
                }
            },
        })
        .js('resources/js/app.js', 'public/dist/js').version()
        .vuetify('vuetify-loader')
         // .vuetify('vuetify-loader', {
         // extract: 'css/vuetify-components.css'})//
        .js('resources/js/guests.js', 'public/dist/js')
        .js('resources/js/auth.js', 'public/dist/js').vuetify('vuetify-loader')
        .js('resources/js/categories-courses.js', 'public/dist/js')
        .js('resources/js/course.js', 'public/dist/js')
        .js('resources/js/courses.js', 'public/dist/js').version()
        .js('resources/js/payment.js', 'public/dist/js')
        .js('resources/js/payment-success.js', 'public/dist/js')
        .js('resources/js/portallifecole.js', 'public/dist/js')
        .js('resources/js/about.js', 'public/dist/js')
        .js('resources/js/landing.js', 'public/dist/js')
        .js('resources/js/reviews.js', 'public/dist/js')
        .js('resources/js/recommender-typeform.js', 'public/dist/js')
        .js('resources/js/new-teacher.js', 'public/dist/js')
        .js('resources/js/faq.js', 'public/dist/js')
        .js('resources/js/trajectories.js', 'public/dist/js')
        .js('resources/js/trajectories-landing.js', 'public/dist/js')
        .js('resources/js/promo.js', 'public/dist/js')
        .js('resources/js/contact.js', 'public/dist/js')
        // .vuetify()
        .sourceMaps()
        .extract(['jquery'], 'dist/js/vendor~utils-1.js')
        .extract(['bootstrap'], 'dist/js/vendor~utils-2.js')
        .extract(['vue'], 'dist/js/vendor~utils-3.js')
        // .webpackConfig(Object.assign(webpackVuetify))
        // .extract({
        //     // If you don't specify a location, it defaults to `vendor.js`
        //     to: 'js/vendor-d3.js',
        //
        //     // This can be an array of strings or a regular expression
        //     libraries: /vuetify\/dist/
        // })
        // .extract([path.resolve(__dirname, './node_modules/vuetify/dist/vuetify.min.js')], 'js/vendor~utils-6.js')
        //.extract([path.resolve(__dirname, './node_modules/vuetify/dist/vuetify.js')], 'js/vendor~utils-4.js')
        .extract(['axios'], 'dist/js/vendor~utils-7.js')
        // .extract(['vuetify'],  'js/vendor~utils-5.js')
        .extract(['popper.js'], 'dist/js/vendor~utils-8.js')
        // .extract(['core-js'],  'js/vendor~utils-9.js')
        .extract()
        .babelConfig({
            presets: ["@babel/preset-env"],
            plugins: ['@babel/plugin-syntax-dynamic-import'],
        })
        .options({
            uglify: true,
        })
        // .minify('public/js/vendor~utils-5.js')
        //.minify('public/js/vendor~utils-1.js')
    mix.webpackConfig({
        optimization: {
            splitChunks: {
                // chunks:'all',
                cacheGroups: {
                    vendors: false,
                    //     vuetify: {
                    //         // regex to compare against build resource by path name (e.g., `/node_modules/vuetify`)
                    //         test: /vuetify\/dist/,
                    //         // basename of output file
                    //         name: 'chunk-vendors-vuetify'
                    //     }
                },
            },
        }
        // optimization: {
        //     splitChunks: {
        //         minSize: 10000,
        //         maxSize: 250000,
        //         cacheGroups: {
        //             // vendor: {
        //             //     test: /[\\/]node_modules[\\/]/,
        //             //     name(module) {
        //             //         const packageName = module.context.match(/[\\/]node_modules[\\/](.*?)([\\/]|$)/)[1];
        //             //         return `npm.${packageName.replace('@', '')}`;
        //             //     },
        //             // },
        //             vuetify: {
        //                 // regex to compare against build resource by path name (e.g., `/node_modules/vuetify`)
        //                 test:  /[\\/]vuetify[\\/]/,
        //                 name(module) {
        //                     const packageName = module.context.match(/[\\/]vuetify[\\/](.*?)([\\/]|$)/)[1];
        //                     return `vuetify.${packageName.replace('@', '')}`;
        //                 },
        //             }
        //         },
        //     },
        // }
    })
    // mix.options({
    //     postCss: [
    //         //require('autoprefixer'),
    //         // require('postcss-import'),
    //         // require('postcss-preset-env')
    //     ]
    // })
    if (mix.inProduction()) {
        // mix.splitJs({
        //     maxChunks: 1000, // The maximum amount of chunks to  split into
        //     productionOnly: false, // Only code split in production
        //     publicPath: '../',
        //     chunkFileName: '[name].js?id=[chunkhash]', // Hash file names by default
        // })
    }
    // /if (process.env.URL==='http://localhost:8000' ) {
        //mix.bundleAnalyzer();
    // }
}

mix.webpackConfig({
    plugins: [
        new CompressionPlugin({
            filename: '[path].gz',
            algorithm: 'gzip',
            test: /\.js$|\.css$|\.html$|\.svg$/,
            threshold: 10240,
            minRatio: 0.78,
        }),
        new CompressionPlugin({
            filename: '[path].br',
            algorithm: 'brotliCompress',
            test: /\.(js|css|html|svg)$/,
            compressionOptions: {
                level: 11,
            },
            threshold: 10240,
            minRatio: 0.78,
        }),
        new FontminPlugin({
            autodetect: true, // automatically pull unicode characters from CSS
            glyphs: ['\uf0c8' /* extra glyphs to include */],
        }),
    ],

    /**
     * Fix Pinia import issue
     * @link https://pinia.vuejs.org
     * @link https://github.com/vuejs/pinia/issues/675
     */
     module: {
        rules: [
            {
                test: /\.mjs$/,
                include: /node_modules/,
                type: "javascript/auto"
            }
        ]
    }
})

/*mix.setPublicPath('public')
 .compressImages(
    'resources/images\/**\/*','assets',
    {
        jpg: {
            engine: 'mozjpeg',
            command: ['-quality', '70']
        },
        png: {
            engine: "pngquant",
            command: ["--quality=20-50", "-o"]
        }
    },
)*/
// if (mix.inProduction()) {
//     mix.options({
//         terser: {
//             terserOptions: {
//                 compress: {
//                     drop_console: true
//                 }
//             }
//         }
//     });
//     mix.version();
// }
