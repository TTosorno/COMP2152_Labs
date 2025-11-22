using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using COMP2139_ICE.Data;
using COMP2139_ICE.Areas.ProjectManagement.Models;

namespace COMP2139_ICE.Areas.ProjectManagement.Controllers;

[Area("ProjectManagement")]
[Route("[area]/[controller]/[action]")]
public class ProjectTaskController : Controller
{
    private readonly ApplicationDbContext _context;

    public ProjectTaskController(ApplicationDbContext context)
    {
        _context = context;
    }

    [HttpGet]
    public async Task<IActionResult> Search(string searchString, int? projectId)
    {
        var tasksQuery = from t in _context.ProjectTasks
                         select t;

        bool searchPerformed = !String.IsNullOrEmpty(searchString);

        if (searchPerformed)
        {
            tasksQuery = tasksQuery.Where(t => t.Title.Contains(searchString) 
                                           || t.Description.Contains(searchString));
        }
        
        if (projectId.HasValue)
        {
            tasksQuery = tasksQuery.Where(t => t.ProjectId == projectId);
            ViewBag.ProjectId = projectId;
        }

        var tasks = await tasksQuery.ToListAsync();
        ViewData["CurrentFilter"] = searchString;
        ViewData["SearchPerformed"] = searchPerformed;

        return View("Index", tasks);
    }

    public async Task<IActionResult> Index(int projectId)
    {
        var tasks = await _context.ProjectTasks
                            .Where(t => t.ProjectId == projectId)
                            .ToListAsync();
        
        ViewBag.ProjectId = projectId;
        return View(tasks);
    }

    public IActionResult Create(int projectId)
    {
        ViewBag.ProjectId = projectId;
        return View();
    }

    [HttpPost]
    [ValidateAntiForgeryToken]
    public async Task<IActionResult> Create(int projectId, ProjectTask projectTask)
    {
        projectTask.ProjectId = projectId;
        ModelState.Remove("Project");

        if (ModelState.IsValid)
        {
            _context.ProjectTasks.Add(projectTask);
            await _context.SaveChangesAsync();
            return RedirectToAction("Index", new { projectId = projectId });
        }
        
        ViewBag.ProjectId = projectId;
        return View(projectTask);
    }

    public async Task<IActionResult> Edit(int id)
    {
        var task = await _context.ProjectTasks.FindAsync(id);
        if (task == null) return NotFound();
        return View(task);
    }

    [HttpPost]
    [ValidateAntiForgeryToken]
    public async Task<IActionResult> Edit(int id, ProjectTask projectTask)
    {
        if (id != projectTask.ProjectTaskId) return NotFound();
        ModelState.Remove("Project");

        if (ModelState.IsValid)
        {
            _context.Update(projectTask);
            await _context.SaveChangesAsync();
            return RedirectToAction("Index", new { projectId = projectTask.ProjectId });
        }
        return View(projectTask);
    }

    public async Task<IActionResult> Delete(int id)
    {
        var task = await _context.ProjectTasks.FindAsync(id);
        if (task == null) return NotFound();
        return View(task);
    }

    [HttpPost, ActionName("Delete")]
    [ValidateAntiForgeryToken]
    public async Task<IActionResult> DeleteConfirmed(int id)
    {
        var task = await _context.ProjectTasks.FindAsync(id);
        if (task != null)
        {
            int projectId = task.ProjectId;
            _context.ProjectTasks.Remove(task);
            await _context.SaveChangesAsync();
            return RedirectToAction("Index", new { projectId = projectId });
        }
        return RedirectToAction("Index", "Home");
    }
    
    public async Task<IActionResult> Details(int id)
    {
        var task = await _context.ProjectTasks
            .Include(t => t.Project)
            .FirstOrDefaultAsync(m => m.ProjectTaskId == id);
            
        if (task == null) return NotFound();
        return View(task);
    }
}