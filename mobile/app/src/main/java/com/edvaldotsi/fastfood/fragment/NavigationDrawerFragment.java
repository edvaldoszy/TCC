package com.edvaldotsi.fastfood.fragment;


import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.widget.Toolbar;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

import com.edvaldotsi.fastfood.R;


/**
 * A simple {@link Fragment} subclass.
 */
public class NavigationDrawerFragment extends Fragment {

    private ActionBarDrawerToggle drawerToggle;
    private DrawerLayout drawerLayout;
    //private View container;


    public NavigationDrawerFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_navigation_drawer, container, false);
    }

    public void setup(int id, DrawerLayout drawerLayout, Toolbar toolbar) {
        //this.container = getActivity().findViewById(id);
        this.drawerLayout = drawerLayout;
        drawerToggle = new ActionBarDrawerToggle(getActivity(), drawerLayout, toolbar, R.string.drawer_open, R.string.drawer_close);
        drawerLayout.setDrawerListener(drawerToggle);
        drawerLayout.post(new Runnable() {
            @Override
            public void run() {
                drawerToggle.syncState();
            }
        });
    }

    public void close() {
        drawerLayout.closeDrawers();
    }
}
