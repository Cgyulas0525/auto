<li class="header">MENŰ</li>
<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('home') !!}"><i class="fa fa-dashboard"></i><span> Vezérlő pult</span></a>
</li>
<li class="treeview">
    <a href="#">
      <i class="fa fa-server"></i>
      <span>Szótár</span>
      <span class="pull-right-container">
        <span class="fa fa-angle-left pull-right"></span>
      </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('costs*') ? 'active' : '' }}">
            <a href="{!! route('costs.index') !!}"><i class="fa fa-book"></i><span> Költség típus</span></a>
        </li>
        <li class="{{ Request::is('partners*') ? 'active' : '' }}">
          <a href="{!! route('partners.index') !!}"><i class="fa fa-users"></i><span> Partnerek</span></a>
        </li>
        <li class="{{ Request::is('doctypes*') ? 'active' : '' }}">
          <a href="{!! route('doctypes.index') !!}"><i class="fa fa-file-text"></i><span> Dokomentum típus</span></a>
        </li>
    </ul>
</li>
<li class="treeview">
    <a href="#">
      <i class="fa fa-cab"></i>
      <span>Autó</span>
      <span class="pull-right-container">
        <span class="fa fa-angle-left pull-right"></span>
      </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('cars*') ? 'active' : '' }}">
            <a href="{!! route('cars.index') !!}"><i class="fa fa-car"></i><span> Autó</span></a>
        </li>
        <li class="{{ Request::is('documents*') ? 'active' : '' }}">
            <a href="{!! route('documents.index') !!}"><i class="fa fa-file-text-o"></i><span>Dokumentumok</span></a>
        </li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
      <i class="fa fa-edit"></i>
      <span>Bevételek</span>
      <span class="pull-right-container">
        <span class="fa fa-angle-left pull-right"></span>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="{{ Request::is('accounts*') ? 'active' : '' }}">
        <a href="{!! route('oiaccounts.index') !!}"><i class="fa fa-upload"></i><span> Kimenő számlák</span></a>
      </li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
      <i class="fa fa-link"></i>
      <span>Költségek</span>
      <span class="pull-right-container">
        <span class="fa fa-angle-left pull-right"></span>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="{{ Request::is('accounts*') ? 'active' : '' }}">
        <a href="{!! route('accounts.index') !!}"><i class="fa fa-sticky-note-o"></i><span> Autó költség számlák</span></a>
      </li>
      <li class="{{ Request::is('accounts*') ? 'active' : '' }}">
        <a href="{!! route('ioaccounts.index') !!}"><i class="fa fa-download"></i><span> Bejövő számlák</span></a>
      </li>
    </ul>
</li>
<li class="treeview">
    <a href="#">
      <i class="fa fa-file-text"></i>
      <span>Lekérdezések</span>
      <span class="pull-right-container">
        <span class="fa fa-angle-left pull-right"></span>
      </span>
    </a>
    <ul class="treeview-menu">
        <li class="treeview">
           <a href="#"><i class="fa fa-file-text-o"></i> Költségek
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
               </span>
           </a>
           <ul class="treeview-menu">
               <li class="{{ Request::is('offers*') ? 'active' : '' }}">
                   <a href="{!! route('autokoltseg.index') !!}"><i class="fa fa-link"></i><span> Autónként</span></a>
               </li>
               <li class="{{ Request::is('offers*') ? 'active' : '' }}">
                   <a href="{!! route('ktgtipus.index') !!}"><i class="fa fa-thumbs-o-up"></i><span> Költség típusonként</span></a>
               </li>
           </ul>
        </li>
    </ul>
</li>


<li class="header">ADMIN</li>
    <li class="{{ Request::is('users*') ? 'active' : '' }}">
        <a href="{!! route('users.index') !!}"><i class="fa fa-user"></i><span>Felhasználók</span></a>
    </li>
</li>
