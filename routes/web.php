<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
//  ==========Client==========
Route::get('/', 'HomeController@Index');

//Menu Brand
Route::post('/menu-brand/{brand_id}', 'BrandController@MenuShowBrand');
Route::get('/shop-now', 'HomeController@MenuShowProductNow');
Route::get('/product-category/{product_type_id}', 'HomeController@MenuShowProductType');
Route::get('/product-brand/{product_brand_id}', 'HomeController@MenuShowProducBrand');
Route::get('/product-collection/{product_collection_id}', 'HomeController@MenuShowProductCollection');

//product detai
Route::get('/product-detail/{product_id}', 'ProductController@ProductDetail');

//Add cart
Route::post('/add-cart/{product_id}', 'CartController@AddToCart');

// ==========Admin==========
Route::get('/admin', 'AdminHomeController@Index');
Route::get('/resetpass', 'AdminHomeController@ResetPassword');
Route::get('/loginadmin', 'AdminHomeController@LoginAdmin');
Route::get('/logout', 'AdminHomeController@Logout');
Route::get('/dashboard', 'AdminHomeController@ShowDashboard');
Route::post('/admin-dashboard', 'AdminHomeController@Dashboard');

//product type admin
Route::get('/product-type', 'ProductTypeController@Index');
Route::get('/product-type-add', 'ProductTypeController@ProductTypeAdd');
Route::post('/product-type-save', 'ProductTypeController@ProductTypeSave');
Route::post('/product-type-save-edit/{pro_type_id}', 'ProductTypeController@ProductTypeSaveEdit');
Route::get('/product-type-edit/{pro_type_id}', 'ProductTypeController@ProductTypeEdit');

Route::get('/unactive-product-type/{pro_type_id}', 'ProductTypeController@UnactiveProductType');
Route::get('/active-product-type/{pro_type_id}', 'ProductTypeController@ActiveProductType');

//Brand
Route::get('/brand', 'BrandController@Index');
Route::get('/brand-add', 'BrandController@BrandAdd');
Route::post('/brand-save', 'BrandController@BrandSave');
Route::post('/brand-save-edit/{brand_id}', 'BrandController@BrandSaveEdit');
Route::get('/brand-edit/{brand_id}', 'BrandController@BrandEdit');

Route::get('/unactive-brand/{brand_id}', 'BrandController@UnactiveBrand');
Route::get('/active-brand/{brand_id}', 'BrandController@ActiveBrand');

//Collection
Route::get('/collection', 'ProductCollectionController@Index');
Route::get('/collection-add', 'ProductCollectionController@CollectionAdd');
Route::post('/collection-save', 'ProductCollectionController@CollectionSave');
Route::post('/collection-save-edit/{collection_id}', 'ProductCollectionController@CollectionSaveEdit');
Route::get('/collection-edit/{collection_id}', 'ProductCollectionController@CollectionEdit');

Route::get('/unactive-collection/{collection_id}', 'ProductCollectionController@UnactiveCollection');
Route::get('/active-collection/{collection_id}', 'ProductCollectionController@ActiveCollection');

//Coupon
Route::get('/coupon-code', 'CouponCodeController@Index');
Route::get('/coupon-code-add', 'CouponCodeController@CouponCodeAdd');
Route::post('/coupon-code-save', 'CouponCodeController@CouponCodeSave');
Route::post('/coupon-code-save-edit/{coupon_code_id}', 'CouponCodeController@CouponCodeSaveEdit');
Route::get('/coupon-code-edit/{coupon_code_id}', 'CouponCodeController@CouponCodeEdit');

Route::get('/unactive-coupon-code/{coupon_code_id}', 'CouponCodeController@UnactiveCouponCode');
Route::get('/active-coupon-code/{coupon_code_id}', 'CouponCodeController@ActiveCouponCode');

//Supplier
Route::get('/supplier', 'SupplierController@Index');
Route::get('/supplier-add', 'SupplierController@SupplierAdd');
Route::post('/supplier-save', 'SupplierController@SupplierSave');
Route::post('/supplier-save-edit/{supplier_id}', 'SupplierController@SupplierSaveEdit');
Route::get('/supplier-edit/{supplier_id}', 'SupplierController@SupplierEdit');
Route::get('/supplier-delete/{supplier_id}', 'SupplierController@SupplierDelete');

Route::get('/unactive-supplier/{supplier_id}', 'SupplierController@UnactiveSupplier');
Route::get('/active-supplier/{supplier_id}', 'SupplierController@ActiveSupplier');

//Size product
Route::get('/size', 'SizeController@Index');
Route::get('/size-add', 'SizeController@SizeAdd');
Route::post('/size-save', 'SizeController@SizeSave');
Route::post('/size-save-edit/{size_id}', 'SizeController@SizeSaveEdit');
Route::get('/size-edit/{size_id}', 'SizeController@SizeEdit');
Route::get('/size-delete/{size_id}', 'SizeController@SizeDelete');

Route::get('/unactive-size/{size_id}', 'SizeController@UnactiveSize');
Route::get('/active-size/{size_id}', 'SizeController@ActiveSize');

//Header show
Route::get('/headershow', 'HeaderShowController@Index');
Route::get('/headershow-add', 'HeaderShowController@HeaderShowAdd');
Route::post('/headershow-save', 'HeaderShowController@HeaderShowSave');
Route::post('/headershow-save-edit/{headershow_id}', 'HeaderShowController@HeaderShowSaveEdit');
Route::get('/headershow-edit/{headershow_id}', 'HeaderShowController@HeaderShowEdit');
Route::get('/headershow-delete/{headershow_id}', 'HeaderShowController@HeaderShowDelete');

Route::get('/unactive-headershow/{headershow_id}', 'HeaderShowController@UnactiveHeaderShow');
Route::get('/active-headershow/{headershow_id}', 'HeaderShowController@ActiveHeaderShow');

//Slideshow
Route::get('/slideshow', 'SlideShowController@Index');
Route::get('/slideshow-add', 'SlideShowController@SlideShowAdd');
Route::post('/slideshow-save', 'SlideShowController@SlideShowSave');
Route::post('/slideshow-save-edit/{slideshow_id}', 'SlideShowController@SlideShowSaveEdit');
Route::get('/slideshow-edit/{slideshow_id}', 'SlideShowController@SlideShowEdit');
Route::get('/slideshow-delete/{slideshow_id}', 'SlideShowController@SlideShowDelete');

Route::get('/unactive-slideshow/{slideshow_id}', 'SlideShowController@UnactiveSlideShow');
Route::get('/active-slideshow/{slideshow_id}', 'SlideShowController@ActiveSlideShow');

//AboutStore
Route::get('/about-store', 'AboutStoreController@Index');
Route::get('/about-store-add', 'AboutStoreController@AboutStoreAdd');
Route::post('/about-store-save', 'AboutStoreController@AboutStoreSave');
Route::post('/about-store-save-edit/{about_store_id}', 'AboutStoreController@AboutStoreSaveEdit');
Route::get('/about-store-edit/{about_store_id}', 'AboutStoreController@AboutStoreEdit');
Route::get('/about-store-delete/{about_store_id}', 'AboutStoreController@AboutStoreDelete');

Route::get('/unactive-about-store/{about_store_id}', 'AboutStoreController@UnactiveAboutStore');
Route::get('/active-about-store/{about_store_id}', 'AboutStoreController@ActiveAboutStore');

//Product News
Route::get('/product-news', 'ProductNewsController@Index');
Route::get('/product-news-add', 'ProductNewsController@ProductNewsAdd');
Route::post('/product-news-save', 'ProductNewsController@ProductNewsSave');
Route::post('/product-news-save-edit/{product_news_id}', 'ProductNewsController@ProductNewsSaveEdit');
Route::get('/product-news-edit/{product_news_id}', 'ProductNewsController@ProductNewsEdit');
Route::get('/product-news-delete/{product_news_id}', 'ProductNewsController@ProductNewsDelete');

Route::get('/unactive-product-news/{product_news_id}', 'ProductNewsController@UnactiveProductNews');
Route::get('/active-product-news/{product_news_id}', 'ProductNewsController@ActiveProductNews');

//Product
Route::get('/product', 'ProductController@Index');
Route::get('/product-add', 'ProductController@ProductAdd');
Route::post('/product-save', 'ProductController@ProductSave');
Route::post('/product-save-edit/{product_id}', 'ProductController@ProductSaveEdit');
Route::get('/product-edit/{product_id}', 'ProductController@ProductEdit');
Route::get('/unactive-product/{product_id}', 'ProductController@UnactiveProduct');
Route::get('/active-product/{product_id}', 'ProductController@ActiveProduct');

//Product Import
Route::get('/product-import', 'ProductImportController@Index');
Route::get('/product-import-add-multiple', 'ProductImportController@ProductImportAddMultiple');
Route::post('/product-import-add-queue', 'ProductImportController@ProductImportAddQueue');
Route::get('/product-import-delete-row-queue', 'ProductImportController@ProductImportDeleteRowQueue');
Route::post('/product-import-add-multiple-save', 'ProductImportController@ProductImportAddMultipleSave');

Route::get('/product-import-add', 'ProductImportController@ProductImportAdd');
Route::post('/product-import-add-save', 'ProductImportController@ProductImportAddSave');
Route::get('/product-import-show-detail/{product_import_id}', 'ProductImportController@ProductImportShowDetail');
Route::post('/product-import-edit-save/{product_import_id}', 'ProductImportController@ProductImportEditSave');
Route::get('/unactive-product-import/{product_import_id}', 'ProductImportController@UnactiveProductImport');
Route::get('/active-product-import/{product_import_id}', 'ProductImportController@ActiveProductImport');


Route::get('/product-import-add-detail/{product_import_id}', 'ProductImportController@ProductImportAddDetail');
Route::post('/product-import-add-detail-save/{product_import_id}', 'ProductImportController@ProductImportAddDetailSave');
Route::get('/product-import-edit-detail/{product_import_detail_id}', 'ProductImportController@ProductImportEditDetail');
Route::post('/product-import-edit-detail-save/{product_import_detail_id}', 'ProductImportController@ProductImportEditDetailSave');

Route::get('/product-import-delete-detail/{product_import_detail}', 'ProductImportController@ProductImportDeletetDetail');



//Demo
Route::get('search', 'ProductImportController@getSearch');
Route::post('search/name', 'ProductImportController@getSearchAjax')->name('search');
Route::get('/demo', 'ProductImportController@home');
Route::post('/demo2', 'ProductImportController@demo');
