ABOUT

This module provides a nested unordered list representation of a complete 
Drupal menu structure. menutree/navigation provides a tree representation of
the navigation menu, menutree/primary-links provides a tree representation
of the primary links menu, etc. If no menu name is specified, the primary
links menu is used. That allows it to be used as a simple menu-based
sitemap, give or take a path alias.  The path menutree/all
provides a list of all flagged menus for sites that have multiple separate
navigation menus.

REQUIREMENTS

- Drupal 6.x

INSTALLATION

- Copy the menutree directory to your modules directory.
- Go to admin/build/modules and enable it.
- Go to admin/build/menutree to optionally set a page title and intro text
  for menutree (sitemap) pages.
- Everything else is handled by the miracle of Drupal's automated install
  system.

UPGRADING FROM 5.x

Please note that the menutree paths have changed (e.g. menutree/1 is
now menutree/navigation), so you will have to update any path aliases
to the new paths.

AUTHOR AND CREDIT

Larry Garfield
http://www.palantir.net/

This module was initially developed by Palantir.net for artsci.wustl.edu, and
released to the Drupal community under the GNU General Public License.

It was upgraded to Drupal 6 by fwalch (http://drupal.org/user/135570) as
part of the 2007/2008 Google Highly Open Participation program (GHOP).
