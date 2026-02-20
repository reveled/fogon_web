import { registerBlockType } from '@wordpress/blocks';
import { useState, useEffect } from '@wordpress/element';
import { useSelect } from '@wordpress/data';
import { TextControl, SelectControl, PanelBody, Icon, RadioControl } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Fragment } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

//Register the block type for taxonomy
registerBlockType( 'crafto/product-tag-widget', {
    title: __( 'Crafto Taxonomy Filter', 'crafto-addons' ),
    category: 'common',
    icon: 'filter',
    attributes: {
        title: { type: 'string', default: 'Filter by Category' },
        selected_option: { type: 'string', default: 'product_cat' },
        selected_orderby: { type: 'string', default: 'name' },
        selected_order: { type: 'string', default: 'ASC' },
        numberof_posts: { type: 'string', default: '' },  
        exclude: { type: 'string', default: '' },
        include: { type: 'string', default: '' },  
    },
    
    edit: ( { attributes, setAttributes } ) => {
        const { title, numberof_posts, selected_option, selected_orderby, selected_order, exclude, include } = attributes; 
 
        const onChangeTitle   = ( newTitle ) => { setAttributes( { title: newTitle } ); },
              onChangeSelect  = ( newValue ) => { setAttributes( { selected_option: newValue } ); },
              onOrderbySelect = ( newValue ) => { setAttributes( { selected_orderby: newValue } ); },
              onOrderSelect   = ( newValue ) => { setAttributes( { selected_order: newValue } ); },
              onChangeExclude = ( newValue ) => { setAttributes( { exclude: newValue } ); },
              onChangeInclude = ( newValue ) => { setAttributes( { include: newValue } ); },
              onChangeNumber  = ( newValue ) => { setAttributes( { numberof_posts: newValue } ); };

        // Fetch the terms of the selected taxonomy
         const fetchedTerms = useSelect( ( select ) => {
           const perPage             = numberof_posts ? numberof_posts : -1,
                 validOrderByOptions = [ 'name', 'slug', 'term_group', 'term_id', 'id', 'count', 'description' ],
                 orderBy             = validOrderByOptions.includes( selected_order ) ? selected_order : 'name',
                 excludeArray        = exclude ? exclude.split( ',' ).map(item => parseInt( item.trim(), 10 ) ).filter( Number.isInteger ) : [],
                 includeArray        = include ? include.split( ',' ).map( item => parseInt( item.trim(), 10 ) ).filter( Number.isInteger ) : [];
            const args = { 
                per_page: perPage,
                hide_empty: true, 
                orderby: orderBy,
            }

            if ( excludeArray.length !== 0 ) {
                args[ 'exclude' ] = excludeArray.length > 0 ? excludeArray : [];
            }
            if ( includeArray.length !== 0 ) {
                args[ 'include' ] = includeArray.length > 0 ? includeArray : [];
            }
            var terms = select( 'core' ).getEntityRecords( 'taxonomy', selected_option, args );
            // Manually handle ascending/descending ordering
            if ( terms && selected_order === 'DESC' ) {
                terms = terms.sort( ( a, b ) => b[orderBy] - a[orderBy] );
            } else if ( terms && selected_order === 'ASC' ) {
                terms = terms.sort( ( a, b ) => a[orderBy] - b[orderBy] );
            }
            return terms;
        }, [ selected_option, numberof_posts, selected_orderby, selected_order, exclude, include ] );
        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody title='Block Settings' initialOpen={ true }>
                        <TextControl
                            label    = 'Title'
                            value    = { title }
                            onChange = { onChangeTitle }
                        />
                        <SelectControl
                            label    = 'Select Taxonomy'
                            value    = { selected_option }
                            options  = { [
                                { label: 'Product By Category', value: 'product_cat' },
                                { label: 'Product By Tag', value: 'product_tag' },
                            ]}
                            onChange = { onChangeSelect }
                        />
                        <SelectControl
                            label    = 'Order by'
                            value    = { selected_orderby }
                            options  = { [
                                { label: 'Default', value: 'term_id' },
                                { label: 'Term ID', value: 'term_id' },
                                { label: 'Name', value: 'name' },
                                { label: 'Count', value: 'count' },
                            ]}
                            onChange = { onOrderbySelect }
                        />
                        <SelectControl
                            label   = 'Order'
                            value   = { selected_order }
                            options = { [
                                { label: 'Default', value: 'ASC' },
                                { label: 'ASC', value: 'ASC' },
                                { label: 'DESC', value: 'DESC' },
                            ] }
                            onChange = { onOrderSelect }
                        />
                        <TextControl
                            label    = 'Exclude'
                            value    = { exclude }
                            onChange = { onChangeExclude }
                        />
                        <TextControl
                            label    = 'Include'
                            value    = { include }
                            onChange = { onChangeInclude }
                        />
                        <TextControl
                            label    = 'Number'
                            value    = {numberof_posts}
                            onChange = { onChangeNumber }
                        />
                    </PanelBody>
                </InspectorControls>
                <div {...useBlockProps()}>
                    <div class='components-placeholder__label'>
                        <span class='block-editor-block-icon'><Icon icon='filter' /></span>
                        { title }
                    </div>
                    {fetchedTerms && fetchedTerms.length > 0 ? (
                        <ul>
                            { fetchedTerms.map( ( term ) => (
                                <li key={ term.id }>{ term.name }</li>
                            ) ) }
                        </ul>
                    ) : (
                        <p>No terms found.</p>
                    )}
                </div>
            </Fragment>
        );
       
    },
    save() {
        // Server-side rendering will handle the output
        return null; // Return null for dynamic blocks
    },
} );

//Register the block type for recent product slider
registerBlockType('crafto/recent-product-slider', {
    title: __( 'Crafto Recent Product Slider', 'crafto-addons' ),
    category: 'common',
    icon: 'filter',
    attributes: {
        title: { type: 'string', default: 'New arrivals' },
        number_of_products: { type: 'string', default: '' },
        orderby: { type: 'string', default: 'date' },
    },

    edit: ( { attributes, setAttributes } ) => {
        const { title, number_of_products, orderby } = attributes;
        const onChangeTitle            = ( newTitle ) => setAttributes( { title: newTitle } ),
              onChangeNumberOfProducts = ( newNumber ) => setAttributes( { number_of_products: newNumber } ),
              onOrderbySelect          = ( newValue ) => setAttributes( { orderby: newValue } );
        return (
            <Fragment>
                 <div {...useBlockProps()}>
                    <div class='components-placeholder__label'>
                        <span class='block-editor-block-icon'><Icon icon='filter' /></span>
                       { attributes.title }
                    </div>
              
                    <TextControl label='Title' value={ title } onChange={ onChangeTitle } />
                    <TextControl
                        label    = 'Number of Products'
                        value    = { number_of_products }
                        onChange = { onChangeNumberOfProducts }
                    />
                    <SelectControl
                        label    = 'Order by'
                        value    = { orderby }
                        options  = { [
                            { label: 'Date', value: 'date' },
                            { label: 'Title', value: 'title' },
                        ] }
                        onChange = { onOrderbySelect }
                    />
               </div>
            </Fragment>
        );
    },

    save() {
        return null; // Dynamic rendering
    },
} );

//Register the block type for attribute
registerBlockType('crafto/product-attribute-filter', {
    title: __( 'Crafto Attribute Filter', 'crafto-addons' ),
    category: 'common',
    icon: 'filter',
    attributes: {
        title: { type: 'string', default: 'Filter by Attribute' },
        selected_option: { type: 'string', default: 'pa_color' },
    },
    edit: ({ attributes, setAttributes }) => {
        const { title, selected_option } = attributes;
        const [availableAttributes, setAvailableAttributes] = useState([]);

        useEffect(() => {
            // Fetch attributes from custom endpoint
            wp.apiFetch({ path: '/crafto/v1/product-attributes' }).then((data) => {
                setAvailableAttributes(data);
            });
        }, []);
        return (
            <div>
                <TextControl
                    label="Title"
                    value={title}
                    onChange={(value) => setAttributes({ title: value })}
                />
                <SelectControl
                    label="Attributes"
                    value={selected_option}
                    options={[
                        { label: 'Select an attribute', value: '' },
                        ...availableAttributes.map((attr) => ({
                            label: attr.name,
                            value: `pa_${attr.slug}`,
                        })),
                    ]}
                    onChange={(value) => setAttributes({ selected_option: value })}
                />
            </div>
        );
    },
    save() {
        return null; // Dynamic rendering on the server side
    },
});

//Register the block type for active filter
registerBlockType('crafto/crafto-active-filter', {
    title: __( 'Crafto Active Filter', 'crafto-addons' ),
    category: 'common',
    icon: 'filter',
    attributes: {
        title: { type: 'string', default: 'Active Filter' },
    },
    edit: ( { attributes, setAttributes } ) => {
        const { title }     = attributes;
        const onChangeTitle = ( newTitle ) => setAttributes( { title: newTitle } );
        return (
            <Fragment>
               <div class='components-placeholder__label'>
                    <span class='block-editor-block-icon'><Icon icon='filter' /></span>
                    { attributes.title }
                </div>
               <TextControl label='Title' value={ title } onChange={ onChangeTitle } />
            </Fragment>
        );
    },

    save() {
        return null; // Dynamic rendering on the server side
    },
});

registerBlockType('crafto/crafto-price-filter', {
    title: __('Crafto Price Filter', 'crafto-addons'),
    category: 'common',
    icon: 'filter',
    attributes: {
        title: { type: 'string', default: 'Filter by price' },
        minPrice: { type: 'number', default: 0 },
        maxPrice: { type: 'number', default: craftoPriceFilterData.maxPrice || 200 }, // Use dynamic max price
    },

    edit: ({ attributes, setAttributes }) => {
        const { title, minPrice, maxPrice } = attributes;
        const [values, setValues] = useState([minPrice, maxPrice]);

        return (
            <Fragment>
                <div className="crafto-price-filter price-range-slider">
                    <div className="components-placeholder__label">
                        <span className="block-editor-block-icon">
                            <i className="dashicons dashicons-filter"></i>
                        </span>
                        {title}
                    </div>
                    <TextControl
                        label={__('Title', 'crafto-addons')}
                        value={title}
                        onChange={(newTitle) => setAttributes({ title: newTitle })}
                    />
                    <div className="price-range-wrap">
                        <div></div>
                        <span className="min"></span>
                        <span className="max"></span>
                    </div>
                    <label className="price-range-label">
                        <span>${values[0]}</span>
                        <span className="separator"></span>
                        <span>${values[1]}</span>
                    </label>
                </div>
            </Fragment>
        );
    },

    save() {
        return null; // PHP handles rendering
    },
});