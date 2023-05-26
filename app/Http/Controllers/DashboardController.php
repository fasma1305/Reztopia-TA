<?php 

<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Orders;
use App\Models\Outlet;
use App\Models\Products;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $active_tenant = Outlet::where('id_user', Auth::user()->id)->select('active')->get();
            // dd($active_tenant);

            if (empty($active_tenant[0])) {
                Auth::logout();
                Alert::error('Tenant not found', 'Please Contact the Admin to add Tenant');
                return redirect()->route('login');
            }

            if ($active_tenant[0]->active != 'active') {
                Auth::logout();
                Alert::error('Tenant is Deactived', 'Please Contact the Admin to Activate the Tenant');
                return redirect()->route('login');
            }

            $active = 'dashboard';
            $tgl = Carbon::now();
            $date = $tgl->month;
            $id = Auth::user()->id;
            // dd($id);

            // $outlet = Outlet::with('user')->where('id_user', $id)->get();



            // CATEGORY, MENU
            $grafik = DB::table('orders')
                ->select(DB::raw('COUNT(orders.id) as id_order'), 'orders.date_order')
                ->join('outlets', 'outlets.id', '=', 'orders.id_outlet')
                // ->join('categories as c', 'c.id_outlet', '=', 'outlets.id')
                ->where('outlets.id_user', $id)
                ->where('orders.id_order_status', 1)
                ->groupBy('orders.date_order')
                ->orderBy('orders.date_order')
                ->get();
            // dd($grafik);

            $order_grafik = array();
            $bulan_grafik = array();
            foreach ($grafik as $item) {
                // $x['id_order'] = (int) $item->id_order;
                // $y['date_order'] = $item->date_order;
                array_push($order_grafik, $item->id_order);
                array_push($bulan_grafik, $item->date_order);
            }
            // dd($order_grafik, $bulan_grafik, $grafik);
            if (Auth::user()->roles == 'kantin') {
                $outlet = DB::table('outlets as o')
                    ->select(
                        'o.name as tenant_name',
                        'c.id as id_category',
                        'p.name as name_product',
                        'o.id'
                    )
                    ->join('categories as c', 'c.id_outlet', 'o.id')
                    ->join('products as p', 'p.id_category', '=', 'c.id')
                    ->where('o.id_user', $id)
                    ->get();
                // dd(empty($outlet[0]));

                $data = DB::table('orders')
                    ->join('outlets', 'outlets.id', '=', 'orders.id_outlet')
                    ->join('categories as c', 'c.id_outlet', '=', 'outlets.id')
                    ->where('outlets.id_user', $id)
                    ->where('orders.id_order_status', 1)
                    // ->where('MONTH(orders.date_order)', $date)
                    // ->whereMonth('orders.date_order', $date)
                    ->groupBy('orders.id')
                    // ->groupBy('orders.date_order')
                    // ->orderBy('orders.date_order', 'asc')
                    ->get();
                $total_order = $data->sum('total');
                $today_order = $data->count('id');
                // $total_category = $outlet->unique('id_category')->count();
                $total_category = Categories::where('id_outlet', $outlet[0]->id)->count();
                // dd($outlet);
                if (!empty($outlet[0])) {
                    $total_menu = $outlet->unique('name_product')->count();
                } else {
                    $total_category = 0;
                    $total_menu = 0;
                }
                // dd($outlet);
                // $tenant_name = $outlet[0]->tenant_name;
                // dd($outlet);
                //         SELECT * FROM products
                // JOIN categories ON products.id_category = categories.id
                // JOIN outlets ON outlets.id = categories.id_outlet
                // JOIN users ON users.id = outlets.id_user

                $data_product = DB::table('products')
                    ->join('categories as c', 'c.id', '=', 'products.id_category')
                    ->join('orders as or', 'or.id_category', '=', 'c.id')
                    ->join('outlets as o', 'o.id', '=', 'or.id_outlet')
                    ->get();
                // dd($data);
                // $order = Orders::with('categories')->get();
                $top_product = DB::table('orders')
                    ->select('p.name', 'p.original_price', 'od.quantity as total')
                    // ->select('p.name', 'p.original_price', 'od.quantity as total')
                    // ->distinct('total')
                    ->join('categories as c', 'c.id', '=', 'orders.id_category')
                    ->join('outlets as o', 'o.id', '=', 'orders.id_outlet')
                    ->join('order_details as od', 'od.id_order', '=', 'orders.id')
                    ->join('products as p', 'p.id', '=', 'od.id_product')
                    ->orderBy('total')
                    ->groupBy('p.name')
                    // ->groupBy('od.id_product')
                    // ->groupBy('total')
                    ->where('o.id_user', $id)
                    // ->where('od.id_product', 1)
                    ->get();

                $total_product = DB::table('orders')
                    ->select('od.quantity as total')
                    // ->select(DB::raw('distinct(od.quantity) as total'))
                    ->join('categories as c', 'c.id', '=', 'orders.id_category')
                    // ->join('products as p', 'p.id_category', '=', 'c.id')
                    ->join('outlets as o', 'o.id', '=', 'orders.id_outlet')
                    ->join('order_details as od', 'od.id_order', '=', 'orders.id')
                    ->join('products as p', 'p.id', '=', 'od.id_product')
                    // ->orderBy('p.id')
                    // ->groupBy('p.name')
                    ->groupBy('total')
                    ->where('o.id_user', $id)
                    ->get();
                // dd($total_product);
                // $categ = Categories::all();
                // dd($top_product);


                return view('tenant.page.dashboard', compact(
                    'active',
                    'today_order',
                    'total_order',
                    'top_product',
                    'outlet',
                    'total_product',
                    'total_category',
                    'total_menu',
                    'order_grafik',
                    'bulan_grafik'
                ));
            } else if (Auth::user()->roles == 'admin') {
                $data = DB::table('orders')
                    ->join('outlets', 'outlets.id', '=', 'orders.id_outlet')
                    ->join('categories as c', 'c.id_outlet', '=', 'outlets.id')
                    ->where('orders.id_order_status', 1)
                    // ->where('MONTH(orders.date_order)', $date)
                    // ->whereMonth('orders.date_order', $date)
                    ->groupBy('orders.id')
                    // ->groupBy('orders.date_order')
                    // ->orderBy('orders.date_order', 'asc')
                    ->get();
                $tenant = Outlet::select('active')->get();
                $active_tenant = $tenant->where('active', 'active')->count();
                $inactive_tenant = $tenant->where('active', 'deactive')->count();
                $total_order = $data->sum('total');
                $today_order = $data->count('id');

                $top_tenant = DB::table('orders as o')
                    ->select('ot.name', DB::raw('COUNT(o.id_outlet) as total_order'))
                    ->join('outlets as ot', 'ot.id', '=', 'o.id_outlet')
                    ->groupBy('ot.name')
                    ->get();
                // dd($top_tenant);
                return view('tenant.page.dashboard', compact(
                    'active',
                    // 'outlet',
                    'total_order',
                    'today_order',
                    'active_tenant',
                    'inactive_tenant',
                    'top_tenant'
                ));
            }
        } catch (Exception $error) {
            dd($error->getMessage());
        }
    }
}