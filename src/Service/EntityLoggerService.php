<?php
// src/Service/EntityLoggerService.php

namespace App\Service;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Orderitem;
use App\Entity\Gem;
use App\Entity\Jewelries;
use App\Entity\Customjewelries;
use App\Entity\Gemtype;
use App\Entity\Gembundles;
use App\Entity\Jewelrytype;
use App\Entity\Admin;

class EntityLoggerService
{
    private ActivityLogger $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->activityLogger = $activityLogger;
        
        // Debug
        $logFile = __DIR__ . '/../../var/log/entity_logger_debug.log';
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - EntityLoggerService CONSTRUCTED\n", FILE_APPEND);
    }

    public function logCreate(object $entity): void
    {
        $logFile = __DIR__ . '/../../var/log/entity_logger_debug.log';
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - EntityLoggerService.logCreate() called for: " . get_class($entity) . "\n", FILE_APPEND);
        
        if ($entity instanceof User) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - It's a User entity!\n", FILE_APPEND);
            $this->logUserCreate($entity);
        } elseif ($entity instanceof Order) {
            $this->logOrderCreate($entity);
        } elseif ($entity instanceof Orderitem) {
            $this->logOrderItemCreate($entity);
        } elseif ($entity instanceof Gem) {
            $this->logGemCreate($entity);
        } elseif ($entity instanceof Jewelries) {
            $this->logJewelriesCreate($entity);
        } elseif ($entity instanceof Customjewelries) {
            $this->logCustomJewelriesCreate($entity);
        } elseif ($entity instanceof Gemtype) {
            $this->logGemTypeCreate($entity);
        } elseif ($entity instanceof Gembundles) {
            $this->logGemBundlesCreate($entity);
        } elseif ($entity instanceof Jewelrytype) {
            $this->logJewelryTypeCreate($entity);
        } elseif ($entity instanceof Admin) {
            $this->logAdminCreate($entity);
        }
    }

    public function logUpdate(object $entity, array $changes = []): void
    {
        if ($entity instanceof User) {
            $this->logUserUpdate($entity, $changes);
        } elseif ($entity instanceof Order) {
            $this->logOrderUpdate($entity, $changes);
        } elseif ($entity instanceof Orderitem) {
            $this->logOrderItemUpdate($entity, $changes);
        } elseif ($entity instanceof Gem) {
            $this->logGemUpdate($entity, $changes);
        } elseif ($entity instanceof Jewelries) {
            $this->logJewelriesUpdate($entity, $changes);
        } elseif ($entity instanceof Customjewelries) {
            $this->logCustomJewelriesUpdate($entity, $changes);
        } elseif ($entity instanceof Gemtype) {
            $this->logGemTypeUpdate($entity, $changes);
        } elseif ($entity instanceof Gembundles) {
            $this->logGemBundlesUpdate($entity, $changes);
        } elseif ($entity instanceof Jewelrytype) {
            $this->logJewelryTypeUpdate($entity, $changes);
        } elseif ($entity instanceof Admin) {
            $this->logAdminUpdate($entity, $changes);
        }
    }

    public function logDelete(object $entity): void
    {
        if ($entity instanceof User) {
            $this->logUserDelete($entity);
        } elseif ($entity instanceof Order) {
            $this->logOrderDelete($entity);
        } elseif ($entity instanceof Orderitem) {
            $this->logOrderItemDelete($entity);
        } elseif ($entity instanceof Gem) {
            $this->logGemDelete($entity);
        } elseif ($entity instanceof Jewelries) {
            $this->logJewelriesDelete($entity);
        } elseif ($entity instanceof Customjewelries) {
            $this->logCustomJewelriesDelete($entity);
        } elseif ($entity instanceof Gemtype) {
            $this->logGemTypeDelete($entity);
        } elseif ($entity instanceof Gembundles) {
            $this->logGemBundlesDelete($entity);
        } elseif ($entity instanceof Jewelrytype) {
            $this->logJewelryTypeDelete($entity);
        } elseif ($entity instanceof Admin) {
            $this->logAdminDelete($entity);
        }
    }

    // ==================== USER LOGGING ====================
    private function logUserCreate(User $user): void
    {
        $logFile = __DIR__ . '/../../var/log/entity_logger_debug.log';
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - logUserCreate() called\n", FILE_APPEND);
        
        $this->activityLogger->log('USER_CREATE', sprintf(
            'User created: %s (ID: %d) | Status: %s | Roles: %s',
            $this->safeMethodCall($user, 'getUsername', 'Unknown'),
            $this->safeMethodCall($user, 'getId', 0),
            $this->safeMethodCall($user, 'getStatus', 'N/A'),
            $this->formatRoles($user->getRoles())
        ));
        
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - ActivityLogger.log() called for USER_CREATE\n", FILE_APPEND);
    }

    private function logUserUpdate(User $user, array $changes): void
    {
        $changeDetails = $this->formatChanges($changes, ['password']);
        
        $this->activityLogger->log('USER_UPDATE', sprintf(
            'User updated: %s (ID: %d)%s',
            $this->safeMethodCall($user, 'getUsername', 'Unknown'),
            $this->safeMethodCall($user, 'getId', 0),
            $changeDetails ? ' | Changes: ' . $changeDetails : ''
        ));
    }

    private function logUserDelete(User $user): void
    {
        $this->activityLogger->log('USER_DELETE', sprintf(
            'User deleted: %s (ID: %d) | Role: %s',
            $this->safeMethodCall($user, 'getUsername', 'Unknown'),
            $this->safeMethodCall($user, 'getId', 0),
            $this->getPrimaryRole($user->getRoles())
        ));
    }

    // ==================== ORDER LOGGING ====================
    private function logOrderCreate(Order $order): void
    {
        $customer = $order->getCustomer();
        $this->activityLogger->log('ORDER_CREATE', sprintf(
            'Order created: ID %d | Customer: %s | Status: %s',
            $this->safeMethodCall($order, 'getId', 0),
            $customer ? $this->safeMethodCall($customer, 'getUsername', 'Unknown') : 'Unknown',
            $this->safeMethodCall($order, 'getStatus', 'N/A')
        ));
    }

    private function logOrderUpdate(Order $order, array $changes): void
    {
        $changeDetails = $this->formatChanges($changes);
        $customer = $order->getCustomer();
        
        $this->activityLogger->log('ORDER_UPDATE', sprintf(
            'Order updated: ID %d | Customer: %s%s',
            $this->safeMethodCall($order, 'getId', 0),
            $customer ? $this->safeMethodCall($customer, 'getUsername', 'Unknown') : 'Unknown',
            $changeDetails ? ' | Changes: ' . $changeDetails : ''
        ));
    }

    private function logOrderDelete(Order $order): void
    {
        $customer = $order->getCustomer();
        $this->activityLogger->log('ORDER_DELETE', sprintf(
            'Order deleted: ID %d | Customer: %s',
            $this->safeMethodCall($order, 'getId', 0),
            $customer ? $this->safeMethodCall($customer, 'getUsername', 'Unknown') : 'Unknown'
        ));
    }

    // ==================== ORDER ITEM LOGGING ====================
    private function logOrderItemCreate(Orderitem $orderItem): void
    {
        $order = $orderItem->getOrder();
        $this->activityLogger->log('ORDER_ITEM_CREATE', sprintf(
            'Order item created: ID %d | Order: %d',
            $this->safeMethodCall($orderItem, 'getId', 0),
            $order ? $this->safeMethodCall($order, 'getId', 0) : 0
        ));
    }

    private function logOrderItemUpdate(Orderitem $orderItem, array $changes): void
    {
        $changeDetails = $this->formatChanges($changes);
        $order = $orderItem->getOrder();
        
        $this->activityLogger->log('ORDER_ITEM_UPDATE', sprintf(
            'Order item updated: ID %d | Order: %d%s',
            $this->safeMethodCall($orderItem, 'getId', 0),
            $order ? $this->safeMethodCall($order, 'getId', 0) : 0,
            $changeDetails ? ' | Changes: ' . $changeDetails : ''
        ));
    }

    private function logOrderItemDelete(Orderitem $orderItem): void
    {
        $order = $orderItem->getOrder();
        $this->activityLogger->log('ORDER_ITEM_DELETE', sprintf(
            'Order item deleted: ID %d | Order: %d',
            $this->safeMethodCall($orderItem, 'getId', 0),
            $order ? $this->safeMethodCall($order, 'getId', 0) : 0
        ));
    }

    // ==================== GEM LOGGING ====================
    private function logGemCreate(Gem $gem): void
    {
        $gemType = $gem->getGemType();
        $this->activityLogger->log('GEM_CREATE', sprintf(
            'Gem created: %s (ID: %d) | Type: %s',
            $this->safeMethodCall($gem, 'getName', 'Unknown'),
            $this->safeMethodCall($gem, 'getId', 0),
            $gemType ? $this->safeMethodCall($gemType, 'getName', 'N/A') : 'N/A'
        ));
    }

    private function logGemUpdate(Gem $gem, array $changes): void
    {
        $changeDetails = $this->formatChanges($changes);
        
        $this->activityLogger->log('GEM_UPDATE', sprintf(
            'Gem updated: %s (ID: %d)%s',
            $this->safeMethodCall($gem, 'getName', 'Unknown'),
            $this->safeMethodCall($gem, 'getId', 0),
            $changeDetails ? ' | Changes: ' . $changeDetails : ''
        ));
    }

    private function logGemDelete(Gem $gem): void
    {
        $this->activityLogger->log('GEM_DELETE', sprintf(
            'Gem deleted: %s (ID: %d)',
            $this->safeMethodCall($gem, 'getName', 'Unknown'),
            $this->safeMethodCall($gem, 'getId', 0)
        ));
    }

    // ==================== JEWELRIES LOGGING ====================
    private function logJewelriesCreate(Jewelries $jewelry): void
    {
        $jewelryType = $jewelry->getJewelryType();
        $this->activityLogger->log('JEWELRY_CREATE', sprintf(
            'Jewelry created: %s (ID: %d) | Type: %s',
            $this->safeMethodCall($jewelry, 'getName', 'Unknown'),
            $this->safeMethodCall($jewelry, 'getId', 0),
            $jewelryType ? $this->safeMethodCall($jewelryType, 'getName', 'N/A') : 'N/A'
        ));
    }

    private function logJewelriesUpdate(Jewelries $jewelry, array $changes): void
    {
        $changeDetails = $this->formatChanges($changes);
        
        $this->activityLogger->log('JEWELRY_UPDATE', sprintf(
            'Jewelry updated: %s (ID: %d)%s',
            $this->safeMethodCall($jewelry, 'getName', 'Unknown'),
            $this->safeMethodCall($jewelry, 'getId', 0),
            $changeDetails ? ' | Changes: ' . $changeDetails : ''
        ));
    }

    private function logJewelriesDelete(Jewelries $jewelry): void
    {
        $this->activityLogger->log('JEWELRY_DELETE', sprintf(
            'Jewelry deleted: %s (ID: %d)',
            $this->safeMethodCall($jewelry, 'getName', 'Unknown'),
            $this->safeMethodCall($jewelry, 'getId', 0)
        ));
    }

    // ==================== CUSTOM JEWELRIES LOGGING ====================
    private function logCustomJewelriesCreate(Customjewelries $customJewelry): void
    {
        $this->activityLogger->log('CUSTOM_JEWELRY_CREATE', sprintf(
            'Custom jewelry created: ID %d | Status: %s',
            $this->safeMethodCall($customJewelry, 'getId', 0),
            $this->safeMethodCall($customJewelry, 'getStatus', 'N/A')
        ));
    }

    private function logCustomJewelriesUpdate(Customjewelries $customJewelry, array $changes): void
    {
        $changeDetails = $this->formatChanges($changes);
        
        $this->activityLogger->log('CUSTOM_JEWELRY_UPDATE', sprintf(
            'Custom jewelry updated: ID %d%s',
            $this->safeMethodCall($customJewelry, 'getId', 0),
            $changeDetails ? ' | Changes: ' . $changeDetails : ''
        ));
    }

    private function logCustomJewelriesDelete(Customjewelries $customJewelry): void
    {
        $this->activityLogger->log('CUSTOM_JEWELRY_DELETE', sprintf(
            'Custom jewelry deleted: ID %d',
            $this->safeMethodCall($customJewelry, 'getId', 0)
        ));
    }

    // ==================== GEM TYPE LOGGING ====================
    private function logGemTypeCreate(Gemtype $gemType): void
    {
        $this->activityLogger->log('GEM_TYPE_CREATE', sprintf(
            'Gem type created: %s (ID: %d)',
            $this->safeMethodCall($gemType, 'getName', 'Unknown'),
            $this->safeMethodCall($gemType, 'getId', 0)
        ));
    }

    private function logGemTypeUpdate(Gemtype $gemType, array $changes): void
    {
        $changeDetails = $this->formatChanges($changes);
        
        $this->activityLogger->log('GEM_TYPE_UPDATE', sprintf(
            'Gem type updated: %s (ID: %d)%s',
            $this->safeMethodCall($gemType, 'getName', 'Unknown'),
            $this->safeMethodCall($gemType, 'getId', 0),
            $changeDetails ? ' | Changes: ' . $changeDetails : ''
        ));
    }

    private function logGemTypeDelete(Gemtype $gemType): void
    {
        $this->activityLogger->log('GEM_TYPE_DELETE', sprintf(
            'Gem type deleted: %s (ID: %d)',
            $this->safeMethodCall($gemType, 'getName', 'Unknown'),
            $this->safeMethodCall($gemType, 'getId', 0)
        ));
    }

    // ==================== GEM BUNDLES LOGGING ====================
    private function logGemBundlesCreate(Gembundles $gemBundle): void
    {
        $this->activityLogger->log('GEM_BUNDLE_CREATE', sprintf(
            'Gem bundle created: %s (ID: %d)',
            $this->safeMethodCall($gemBundle, 'getName', 'Unknown'),
            $this->safeMethodCall($gemBundle, 'getId', 0)
        ));
    }

    private function logGemBundlesUpdate(Gembundles $gemBundle, array $changes): void
    {
        $changeDetails = $this->formatChanges($changes);
        
        $this->activityLogger->log('GEM_BUNDLE_UPDATE', sprintf(
            'Gem bundle updated: %s (ID: %d)%s',
            $this->safeMethodCall($gemBundle, 'getName', 'Unknown'),
            $this->safeMethodCall($gemBundle, 'getId', 0),
            $changeDetails ? ' | Changes: ' . $changeDetails : ''
        ));
    }

    private function logGemBundlesDelete(Gembundles $gemBundle): void
    {
        $this->activityLogger->log('GEM_BUNDLE_DELETE', sprintf(
            'Gem bundle deleted: %s (ID: %d)',
            $this->safeMethodCall($gemBundle, 'getName', 'Unknown'),
            $this->safeMethodCall($gemBundle, 'getId', 0)
        ));
    }

    // ==================== JEWELRY TYPE LOGGING ====================
    private function logJewelryTypeCreate(Jewelrytype $jewelryType): void
    {
        $this->activityLogger->log('JEWELRY_TYPE_CREATE', sprintf(
            'Jewelry type created: %s (ID: %d)',
            $this->safeMethodCall($jewelryType, 'getName', 'Unknown'),
            $this->safeMethodCall($jewelryType, 'getId', 0)
        ));
    }

    private function logJewelryTypeUpdate(Jewelrytype $jewelryType, array $changes): void
    {
        $changeDetails = $this->formatChanges($changes);
        
        $this->activityLogger->log('JEWELRY_TYPE_UPDATE', sprintf(
            'Jewelry type updated: %s (ID: %d)%s',
            $this->safeMethodCall($jewelryType, 'getName', 'Unknown'),
            $this->safeMethodCall($jewelryType, 'getId', 0),
            $changeDetails ? ' | Changes: ' . $changeDetails : ''
        ));
    }

    private function logJewelryTypeDelete(Jewelrytype $jewelryType): void
    {
        $this->activityLogger->log('JEWELRY_TYPE_DELETE', sprintf(
            'Jewelry type deleted: %s (ID: %d)',
            $this->safeMethodCall($jewelryType, 'getName', 'Unknown'),
            $this->safeMethodCall($jewelryType, 'getId', 0)
        ));
    }

    // ==================== ADMIN LOGGING ====================
    private function logAdminCreate(Admin $admin): void
    {
        $this->activityLogger->log('ADMIN_CREATE', sprintf(
            'Admin created: %s (ID: %d)',
            $this->safeMethodCall($admin, 'getUsername', 'Unknown'),
            $this->safeMethodCall($admin, 'getId', 0)
        ));
    }

    private function logAdminUpdate(Admin $admin, array $changes): void
    {
        $changeDetails = $this->formatChanges($changes);
        
        $this->activityLogger->log('ADMIN_UPDATE', sprintf(
            'Admin updated: %s (ID: %d)%s',
            $this->safeMethodCall($admin, 'getUsername', 'Unknown'),
            $this->safeMethodCall($admin, 'getId', 0),
            $changeDetails ? ' | Changes: ' . $changeDetails : ''
        ));
    }

    private function logAdminDelete(Admin $admin): void
    {
        $this->activityLogger->log('ADMIN_DELETE', sprintf(
            'Admin deleted: %s (ID: %d)',
            $this->safeMethodCall($admin, 'getUsername', 'Unknown'),
            $this->safeMethodCall($admin, 'getId', 0)
        ));
    }

    // ==================== HELPER METHODS ====================
    private function safeMethodCall($object, string $method, $default = 'Unknown')
    {
        if ($object && method_exists($object, $method)) {
            try {
                $result = $object->$method();
                return $result !== null ? $result : $default;
            } catch (\Exception $e) {
                return $default;
            }
        }
        return $default;
    }

    private function formatRoles(array $roles): string
    {
        // Remove ROLE_USER if present (it's added automatically)
        $filteredRoles = array_filter($roles, fn($role) => $role !== 'ROLE_USER');
        
        if (empty($filteredRoles)) {
            return 'USER';
        }
        
        return implode(', ', array_map(function($role) {
            return str_replace('ROLE_', '', $role);
        }, $filteredRoles));
    }

    private function getPrimaryRole(array $roles): string
    {
        // Get the highest role (Admin > Staff > User)
        if (in_array('ROLE_ADMIN', $roles, true)) {
            return 'Admin';
        }
        if (in_array('ROLE_STAFF', $roles, true)) {
            return 'Staff';
        }
        return 'User';
    }

    private function formatChanges(array $changes, array $excludeFields = []): string
    {
        if (empty($changes)) {
            return '';
        }

        $details = [];
        foreach ($changes as $field => $change) {
            // Skip excluded fields (like passwords)
            if (in_array($field, $excludeFields, true)) {
                $details[] = "$field: [CHANGED]";
                continue;
            }
            
            $oldValue = $this->formatValue($change[0] ?? null);
            $newValue = $this->formatValue($change[1] ?? null);
            
            $details[] = "$field: $oldValue → $newValue";
        }

        return implode(', ', $details);
    }

    private function formatValue($value): string
    {
        if ($value === null) {
            return 'NULL';
        }
        
        if (is_array($value)) {
            return json_encode($value);
        }
        
        if (is_object($value)) {
            if (method_exists($value, '__toString')) {
                return (string) $value;
            }
            if (method_exists($value, 'getId')) {
                return get_class($value) . '#' . $value->getId();
            }
            if ($value instanceof \DateTimeInterface) {
                return $value->format('Y-m-d H:i:s');
            }
            return get_class($value);
        }
        
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        
        // Truncate long strings
        $stringValue = (string) $value;
        if (strlen($stringValue) > 100) {
            return substr($stringValue, 0, 100) . '...';
        }
        
        return $stringValue;
    }
}