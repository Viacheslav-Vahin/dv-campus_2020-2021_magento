/**
 * grunt exec:viacheslav_luma_en_us && grunt less:viacheslav_luma_en_us && grunt watch
 */

module.exports = {
    viacheslav_luma_en_us: {
        area: 'frontend',
        name: 'Viacheslav/luma',
        locale: 'en_US',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    }
};
