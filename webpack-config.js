// module.exports = {
//     module: {
//         rules: [
//             {
//                 test: /\.s(c|a)ss$/,
//                 use: [
//                     'vue-style-loader',
//                     'css-loader',
//                     {
//                         loader: 'sass-loader',
//                         // Requires >= sass-loader@^8.0.0
//                         options: {
//                             implementation: require('sass'),
//                             sassOptions: {
//                                 indentedSyntax: true // optional
//                             },
//                         },
//                     },
//                 ],
//             },
//         ],
//     }
// }
/*
module.exports = {
    module: {
        configureWebpack: {
            optimization: {
                splitChunks: {
                    chunks: 'all',
                    maxInitialRequests: Infinity,
                    minSize: 0,
                    cacheGroups: {
                        vuetify: {
                            // regex to compare against build resource by path name (e.g., `/node_modules/vuetify`)
                            test: /vuetify/,

                            // basename of output file
                            name: 'chunk-vendors-vuetify'
                        }
                    },
                },
            },
        }
    }
}
*/
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');
module.exports = {
    plugins: [
        new VuetifyLoaderPlugin(
            // {  breakpoint: {
            //         isActive:false  // This is equivalent to a value of 960
            //     },
            //     theme: {
            //         themes: {
            //             dark: {
            //                 primary: '#321321'
            //             }
            //         }
            //     }
            // }
        ),
    ]
};
